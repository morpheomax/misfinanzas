<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IngresoController extends Controller
{
    use AuthorizesRequests;
    // Mostrar lista de ingresos
    public function index(Request $request)
    {
        // Obtener el año seleccionado, si no se pasa, usar el año actual
        $anio = $request->input('anio', date('Y'));

        // Obtener los años disponibles
        $aniosDisponibles = $this->aniosDisponibles();

        // Obtener el año seleccionado desde el formulario
        $anioSeleccionado = $request->get('anio', $aniosDisponibles->first()); // Default al primer año si no se selecciona ninguno

        $query = $this->filtrosIngreso($request);

        $ingresos = $query->paginate(10);

        // Obtener datos agrupados por mes y categoría
        $datosAgrupados = $this->ingresosPorMesYCategoriaAgrupados($anio);

        // Obtener acumulados anuales y por categoría
        $acumuladoAnual = $this->acumuladoAnual($anio);
        $acumuladoAnualCategoria = $this->acumuladoAnualCategoria($anio);

        // Datos gráficos y acumulados
        $ingresosPorCategoria = $this->ingresosPorCategoria($anio);

        // Datos gráficos y acumulados
        $totalesMensuales = $this->calcularTotalesMensuales($anio);

        // Si la solicitud es AJAX, devolver los componentes en formato JSON
        if ($request->ajax()) {
            $acumuladoAnualView = view('ingresos.acumulado-anual', ['acumuladoAnual' => $acumuladoAnual])->render();
            $acumuladoAnualCategoriaView = view('ingresos.acumulado-anual-categoria', ['acumuladoAnualCategoria' => $acumuladoAnualCategoria])->render();

            return response()->json([
                'acumuladoAnual' => $acumuladoAnualView,
                'acumuladoAnualCategoria' => $acumuladoAnualCategoriaView,
            ]);
        }

        return view('ingresos.index', [
            'ingresos' => $ingresos,
            'anio' => $anio,
            'aniosDisponibles' => $aniosDisponibles,
            'anioSeleccionado' => $anioSeleccionado,
            'aniosDisponibles' => $this->aniosDisponibles(),
            'meses' => $this->meses(),
            'ingresosPorMesYCategoria' => $datosAgrupados['datosAgrupados'],
            'totalesPorCategoria' => $datosAgrupados['totalesPorCategoria'],
            'acumuladoAnual' => $acumuladoAnual,
            'acumuladoAnualCategoria' => $acumuladoAnualCategoria,
            'ingresosPorCategoria' => $ingresosPorCategoria,
            'totalesMensuales' => $totalesMensuales,
        ]);
    }

    // Filtra los ingresos por los parámetros de la solicitud
    private function filtrosIngreso(Request $request)
    {
        $query = Ingreso::where('user_id', Auth::id());

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
        return Ingreso::where('user_id', Auth::id())
            ->distinct()
            ->orderByRaw('YEAR(fecha) DESC')
            ->selectRaw('YEAR(fecha) as year')
            ->pluck('year');
    }

    // Calcular ingresos por mes y categoría agrupados
    // private function ingresosPorMesYCategoriaAgrupados($anio)
    // {
    //     $ingresos = Ingreso::where('user_id', Auth::id())
    //         ->whereYear('fecha', $anio)
    //         ->whereIn('categoria', ['Ingresos Fijos', 'Ingresos Variables']) // Filtra solo estas categorías
    //         ->selectRaw('MONTH(fecha) as mes, categoria, SUM(monto) as total_monto')
    //         ->groupBy('mes', 'categoria')
    //         ->orderBy('mes')
    //         ->orderBy('categoria')
    //         ->get();

    //     $datosAgrupados = $ingresos->groupBy('categoria')->map(function ($grupo) {
    //         return $grupo->keyBy('mes')->pluck('total_monto');
    //     });

    //     $totalesPorCategoria = $ingresos->groupBy('categoria')->map(function ($grupo) {
    //         return $grupo->sum('total_monto');
    //     });

    //     return ['datosAgrupados' => $datosAgrupados, 'totalesPorCategoria' => $totalesPorCategoria];
    // }

    private function ingresosPorMesYCategoriaAgrupados($anio)
    {
        $ingresos = Ingreso::where('user_id', Auth::id())
            ->whereYear('fecha', $anio)
            ->whereIn('categoria', ['Ingresos Fijos', 'Ingresos Variables']) // Filtra solo estas categorías
            ->selectRaw('MONTH(fecha) as mes, categoria, SUM(monto) as total_monto')
            ->groupBy('mes', 'categoria')
            ->orderBy('mes')
            ->orderBy('categoria')
            ->get();

        // Agrupar por categoría y organizar los meses
        $datosAgrupados = $ingresos->groupBy('categoria')->map(function ($grupo) {
            return $grupo->pluck('total_monto', 'mes'); // Optimizado para solo obtener 'total_monto' y 'mes'
        });

        // Calcular los totales por categoría
        $totalesPorCategoria = $ingresos->groupBy('categoria')->map(function ($grupo) {
            return $grupo->sum('total_monto');
        });

        return ['datosAgrupados' => $datosAgrupados, 'totalesPorCategoria' => $totalesPorCategoria];
    }

    // Calcular acumulado anual
    private function acumuladoAnual($anio)
    {
        return Ingreso::where('user_id', Auth::id())
            ->whereYear('fecha', $anio)
            ->selectRaw('YEAR(fecha) as year, SUM(monto) as total_monto')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->paginate(4);
    }

    // Calcular acumulado anual por categoría
    private function acumuladoAnualCategoria($anio)
    {
        return Ingreso::where('user_id', Auth::id())
            ->whereYear('fecha', $anio)
            ->selectRaw('YEAR(fecha) as year, categoria, SUM(monto) as total_monto')
            ->groupBy('year', 'categoria')
            ->orderBy('year', 'desc')
            ->paginate(2);
    }

    // Obtener ingresos por categoría
    private function ingresosPorCategoria($anio)
    {
        return Ingreso::where('user_id', Auth::id())
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
        // Obtenemos los ingresos del año seleccionado del usuario logueado y los agrupamos por mes
        $totalesMensuales = Ingreso::selectRaw('MONTH(fecha) as mes, SUM(monto) as total')
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

    // Mostrar formulario de creación
    public function create(Request $request)
    {

        // Retornar la vista con las categorías
        return view('ingresos.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        // Validación de los datos recibidos
        $data = $request->validate([
            'tipo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255', // o 'exists:categorias,nombre' si es una relación
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
        ]);

        // Crear el nuevo ingreso en la base de datos
        Ingreso::create([
            'categoria' => $data['tipo'], // Asignamos la categoría como tipo (si es necesario)
            'nombre' => $data['nombre'], // Asegúrate de que este campo es correcto
            'monto' => $data['monto'],
            'fecha' => $data['fecha'],
            'user_id' => Auth::id(), // Asumiendo que el usuario está autenticado
        ]);

        // Redirigir o devolver una respuesta
        //return redirect()->route('ingresos.index')->with('success', 'Ingreso registrado exitosamente');
        return redirect()->route('ingresos.index')->with('swal', [
            'title' => '¡Éxito!',
            'text' => 'Ingreso registrado exitosamente',
            'icon' => 'success',
        ]);

    }
    // Mostrar ingreso
    public function show(Ingreso $ingreso)
    {
        $validated['user_id'] = Auth::id();
        $this->authorize('view', $ingreso);
        return view('ingresos.show', compact('ingreso'));
    }

    // Editar ingreso
    public function edit(Ingreso $ingreso)
    {
        // Autorizar al usuario antes de permitirle editar el registro
        $this->authorize('update', $ingreso);

        // Si la autorización pasa, se pasa el ingreso a la vista
        return view('ingresos.edit', compact('ingreso'));
    }

    // Actualizar ingreso
    public function update(Request $request, Ingreso $ingreso)
    {
        // Validar los datos que llegan del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
        ]);

        // Autorización para actualizar el ingreso
        $this->authorize('update', $ingreso); // Verificamos si el usuario tiene permiso para actualizar

        // Actualizar el ingreso con los datos validados
        $ingreso->update($validatedData);

        // Redirigir a la lista de ingresos con un mensaje de éxito
        //return redirect()->route('ingresos.index')->with('success', 'Ingreso actualizado correctamente');
        return redirect()->route('ingresos.index')->with('swal', [
            'title' => '¡Éxito!',
            'text' => 'Ingreso actualizado correctamente',
            'icon' => 'info',
        ]);
    }

    // Eliminar ingreso
    public function destroy(Ingreso $ingreso)
    {
        $this->authorize('delete', $ingreso);
        $ingreso->delete();
        //return redirect()->route('ingresos.index')->with('success', 'Ingreso eliminado correctamente.');
        return redirect()->route('ingresos.index')->with('swal', [
            'title' => 'Atención!',
            'text' => 'Ingreso eliminado correctamente.',
            'icon' => 'warning',
        ]);
    }

    // Duplicar ingreso
    public function duplicate(Ingreso $ingreso)
    {
        $this->authorize('create', $ingreso);

        $newIngreso = $ingreso->replicate();
        $newIngreso->fecha = now(); // Actualizar la fecha si es necesario
        $newIngreso->save();

        //return redirect()->route('ingresos.index')->with('success', 'Ingreso duplicado correctamente.');
        return redirect()->route('ingresos.index')->with('swal', [
            'title' => 'Atención!',
            'text' => 'Ingreso duplicado correctamente.',
            'icon' => 'success',
        ]);
    }

}
