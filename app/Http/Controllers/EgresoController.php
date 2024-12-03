<?php

namespace App\Http\Controllers;

use App\Models\Egreso;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EgresoController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener el año seleccionado, si no se pasa, usar el año actual
        $anio = $request->input('anio', date('Y'));

        // Obtener los años disponibles
        $aniosDisponibles = $this->aniosDisponibles();

        // Obtener el año seleccionado desde el formulario
        $anioSeleccionado = $request->get('anio', $aniosDisponibles->first()); // Default al primer año si no se selecciona ninguno

        $query = $this->filtrosEgreso($request);

        $egresos = $query->paginate(10);

        // Obtener datos agrupados por mes y categoría
        $datosAgrupados = $this->egresosPorMesYCategoriaAgrupados($anio);

        // Obtener acumulados anuales y por categoría
        $acumuladoAnual = $this->acumuladoAnual($anio);
        $acumuladoAnualCategoria = $this->acumuladoAnualCategoria($anio);

        // Datos gráficos y acumulados
        $egresosPorCategoria = $this->egresosPorCategoria($anio);

        // Datos gráficos y acumulados
        $totalesMensuales = $this->calcularTotalesMensuales($anio);

        // Si la solicitud es AJAX, devolver los componentes en formato JSON
        if ($request->ajax()) {
            $acumuladoAnualView = view('egresos.acumulado-anual', ['acumuladoAnual' => $acumuladoAnual])->render();
            $acumuladoAnualCategoriaView = view('egresos.acumulado-anual-categoria', ['acumuladoAnualCategoria' => $acumuladoAnualCategoria])->render();

            return response()->json([
                'acumuladoAnual' => $acumuladoAnualView,
                'acumuladoAnualCategoria' => $acumuladoAnualCategoriaView,
            ]);
        }

        return view('egresos.index', [
            'egresos' => $egresos,
            'anio' => $anio,
            'aniosDisponibles' => $aniosDisponibles,
            'anioSeleccionado' => $anioSeleccionado,
            'aniosDisponibles' => $this->aniosDisponibles(),
            'meses' => $this->meses(),
            'egresosPorMesYCategoria' => $datosAgrupados['datosAgrupados'],
            'totalesPorCategoria' => $datosAgrupados['totalesPorCategoria'],
            'acumuladoAnual' => $acumuladoAnual,
            'acumuladoAnualCategoria' => $acumuladoAnualCategoria,
            'egresosPorCategoria' => $egresosPorCategoria,
            'totalesMensuales' => $totalesMensuales,
        ]);

    }

    // Filtra los egresos por los parámetros de la solicitud
    private function filtrosEgreso(Request $request)
    {
        $query = Egreso::where('user_id', Auth::id());

        // Filtros por fechas
        if ($request->filled('desde') && $request->filled('hasta')) {
            $query->whereBetween('fecha', [$request->desde, $request->hasta]);
        }

        // Filtro por palabra clave
        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        return $query;
    }

    // Obtiene los años disponibles para el filtro
    private function aniosDisponibles()
    {
        return Egreso::where('user_id', Auth::id())
            ->distinct()
            ->orderByRaw('YEAR(fecha) DESC')
            ->selectRaw('YEAR(fecha) as year')
            ->pluck('year');
    }

    private function egresosPorMesYCategoriaAgrupados($anio)
    {
        $egresos = Egreso::where('user_id', Auth::id())
            ->whereYear('fecha', $anio)
            ->whereIn('categoria', ['Egresos Fijos', 'Egresos Variables']) // Filtra solo estas categorías
            ->selectRaw('MONTH(fecha) as mes, categoria, SUM(monto) as total_monto')
            ->groupBy('mes', 'categoria')
            ->orderBy('mes')
            ->orderBy('categoria')
            ->get();

        // Agrupar por categoría y organizar los meses
        $datosAgrupados = $egresos->groupBy('categoria')->map(function ($grupo) {
            return $grupo->pluck('total_monto', 'mes'); // Optimizado para solo obtener 'total_monto' y 'mes'
        });

        // Calcular los totales por categoría
        $totalesPorCategoria = $egresos->groupBy('categoria')->map(function ($grupo) {
            return $grupo->sum('total_monto');
        });

        return ['datosAgrupados' => $datosAgrupados, 'totalesPorCategoria' => $totalesPorCategoria];
    }

    // Calcular acumulado anual
    private function acumuladoAnual($anio)
    {
        return Egreso::where('user_id', Auth::id())
            ->whereYear('fecha', $anio)
            ->selectRaw('YEAR(fecha) as year, SUM(monto) as total_monto')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->paginate(4);
    }

// Calcular acumulado anual por categoría
    private function acumuladoAnualCategoria($anio)
    {
        return Egreso::where('user_id', Auth::id())
            ->whereYear('fecha', $anio)
            ->selectRaw('YEAR(fecha) as year, categoria, SUM(monto) as total_monto')
            ->groupBy('year', 'categoria')
            ->orderBy('year', 'desc')
            ->paginate(2);
    }

    // Obtener egresos por categoría
    private function egresosPorCategoria($anio)
    {
        return Egreso::where('user_id', Auth::id())
            ->whereYear('fecha', $anio)
            ->selectRaw('categoria, SUM(monto) as total_monto')
            ->groupBy('categoria')
            ->orderBy('total_monto', 'desc')
            ->get();
    }

    // Listado de meses
    private function meses()
    {
        return [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
        ];
    }

    // Graficar totales
    private function calcularTotalesMensuales($anio)
    {
        // Obtenemos los egresos del año seleccionado del usuario logueado y los agrupamos por mes
        $totalesMensuales = Egreso::selectRaw('MONTH(fecha) as mes, SUM(monto) as total')
            ->whereYear('fecha', $anio)
            ->where('user_id', Auth::id()) // Filtramos por el ID del usuario logueado
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes');

        // Crear un array con 0 para todos los meses, si no hay datos para ese mes
        $meses = collect(range(1, 12))->mapWithKeys(function ($mes) use ($totalesMensuales) {
            return [$mes => $totalesMensuales->get($mes, 0)];
        });

        return $meses;
    }

    /**
     * Show the form for creating a new resource.
     */
    // Mostrar formulario de creación
    public function create(Request $request)
    {

        // Retornar la vista con las categorías
        return view('egresos.create', compact('tipos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // Validación de los datos recibidos
        $data = $request->validate([
            'tipo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255', // o 'exists:categorias,nombre' si es una relación
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
        ]);

        // Crear el nuevo egreso en la base de datos
        Egreso::create([
            'categoria' => $data['tipo'], // Asignamos la categoría como tipo (si es necesario)
            'nombre' => $data['nombre'], // Asegúrate de que este campo es correcto
            'monto' => $data['monto'],
            'fecha' => $data['fecha'],
            'user_id' => Auth::id(), // Asumiendo que el usuario está autenticado
        ]);

        // Redirigir o devolver una respuesta

        return redirect()->route('egresos.index')->with('swal', [
            'title' => '¡Éxito!',
            'text' => 'Egreso registrado exitosamente',
            'icon' => 'success',
        ]);
    }

    // Mostrar egreso
    public function show(Egreso $egreso)
    {
        //

        $validated['user_id'] = Auth::id();
        $this->authorize('view', $egreso);
        return view('egresos.show', compact('egreso'));
    }

    // Editar egreso
    public function edit(Egreso $egreso)
    {
        // Autorizar al usuario antes de permitirle editar el registro
        $this->authorize('update', $egreso);

        // Si la autorización pasa, se pasa el egreso a la vista
        return view('egresos.edit', compact('egreso'));
    }

    // Actualizar egreso
    public function update(Request $request, Egreso $egreso)
    {
        // Validar los datos que llegan del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
        ]);

        // Autorización para actualizar el egreso
        $this->authorize('update', $egreso); // Verificamos si el usuario tiene permiso para actualizar

        // Actualizar el egreso con los datos validados
        $egreso->update($validatedData);

        // Redirigir a la lista de egresos con un mensaje de éxito
        return redirect()->route('egresos.index')->with('swal', [
            'title' => '¡Éxito!',
            'text' => 'Egreso actualizado correctamente',
            'icon' => 'info',
        ]);
    }

    // Eliminar egreso
    public function destroy(Egreso $egreso)
    {
        $this->authorize('delete', $egreso);
        $egreso->delete();

        return redirect()->route('egresos.index')->with('swal', [
            'title' => 'Atención!',
            'text' => 'Egreso eliminado correctamente.',
            'icon' => 'warning',
        ]);
    }
}
