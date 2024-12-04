<?php

namespace App\Http\Controllers;

use App\Models\Meta;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MetaController extends Controller
{
    use AuthorizesRequests;

    // Display a listing of the resource.
    public function index(Request $request)
    {
        $userId = Auth::id();
        $filtroAnio = $request->input('anio', now()->year);
        // Obtener los años disponibles
        $aniosDisponibles = $this->aniosDisponibles($userId);
        // Si no hay un año seleccionado, establecer el año actual como predeterminado
        $anioSeleccionado = $request->get('anio', date('Y')); // Usa el año actual si no hay selección

        // Datos principales
        $metas = Meta::where('user_id', $userId)->paginate(10);
        $metasPorMes = $this->metasAgrupadasPorMes($filtroAnio);
        $totalesPorAnio = $this->contarMetas($filtroAnio);
        $totalesMensuales = $this->calcularAhorroMensual($filtroAnio);

        // Obtener el año seleccionado desde el formulario
        $anioSeleccionado = $request->get('anio', $aniosDisponibles->first());

        return view('metas.index', [
            'metas' => $metas,
            'metasPorMes' => $metasPorMes,
            'aniosDisponibles' => $aniosDisponibles,
            'anioSeleccionado' => $anioSeleccionado,
            'aniosDisponibles' => $this->aniosDisponibles($userId),

            'totalesPorAnio' => $totalesPorAnio,
            'totalesMensuales' => $totalesMensuales,

            'anio' => $anioSeleccionado,
            'filtroAnio' => $filtroAnio,
        ]);
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('metas.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Validación de los datos recibidos
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'monto' => 'required|numeric',
            'monto_ahorrado' => 'required|numeric',
            'fecha' => 'required|date',
        ]);

        // Crear el nuevo egreso en la base de datos
        Meta::create([
            'nombre' => $data['nombre'],
            'monto' => $data['monto'],
            'monto_ahorrado' => $data['monto_ahorrado'],
            'fecha' => $data['fecha'],
            'user_id' => Auth::id(),
        ]);

        // Redirigir o devolver una respuesta
        return redirect()->route('metas.index')->with('swal', [
            'title' => '¡Éxito!',
            'text' => 'Meta registrada exitosamente',
            'icon' => 'success',
        ]);
    }

    // Show the specified resource.
    public function show(Meta $meta)
    {
        $validated['user_id'] = Auth::id();
        $this->authorize('view', $meta);
        return view('metas.show', compact('meta'));
    }

    // Show the form for editing the specified resource.
    public function edit(Meta $meta)
    {
        $this->authorize('update', $meta);
        return view('metas.edit', compact('meta'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, Meta $meta)
    {
        $validateData = $request->validate([
            'nombre' => 'required|string|max:255',
            'monto' => 'required|numeric',
            'monto_ahorrado' => 'required|numeric',
            'fecha' => 'required|date',
        ]);
        // Autorización para actualizar el egreso
        $this->authorize('update', $meta);
        // Actualizar el egreso con los datos validados
        $meta->update($validateData);

// Redirigir a la lista de egresos con un mensaje de éxito
        return redirect()->route('metas.index')->with('swal', [
            'title' => '¡Éxito!',
            'text' => 'Egreso actualizado correctamente',
            'icon' => 'info',
        ]);
    }

    // Remove the specified resource from storage.
    public function destroy(Meta $meta)
    {
        $this->authorize('delete', $meta);
        $meta->delete();

        return redirect()->route('metas.index')->with('swal', [
            'title' => 'Atención!',
            'text' => 'Egreso eliminado correctamente.',
            'icon' => 'warning',
        ]);
    }

    // Validar los datos de una meta.
    private function validateMeta(Request $request)
    {
        return $request->validate([
            'nombre' => 'required|string|max:255',
            'monto' => 'required|numeric',
            'monto_ahorrado' => 'required|numeric',
            'fecha' => 'required|date',
        ]);
    }

    // Agrupar metas por mes para un año específico.
    // private function metasAgrupadasPorMes($anio)
    // {
    //     $meses = $this->meses();
    //     $metas = Meta::where('user_id', Auth::id())
    //         ->whereYear('fecha', $anio)
    //         ->get()
    //         ->groupBy('mes');

    //     return collect($meses)->mapWithKeys(fn($nombreMes, $numMes) => [
    //         $nombreMes => $metas->get($numMes, collect([]))
    //     ]);
    // }
    // Agrupar metas por mes para un año específico.
    private function metasAgrupadasPorMes($anio)
    {
        $meses = $this->meses();

        $metas = Meta::where('user_id', Auth::id())
            ->whereYear('fecha', $anio)
            ->selectRaw('MONTH(fecha) as mes, user_id, id') // Selecciona el mes usando MONTH(fecha)
            ->get()
            ->groupBy('mes'); // Agrupa por el mes calculado en la consulta

        return collect($meses)->mapWithKeys(fn($nombreMes, $numMes) => [
            $nombreMes => $metas->get($numMes, collect([]))
        ]);
    }

    // Obtener los años disponibles para el filtro.
    private function AniosDisponibles($userId)
    {
        return Meta::where('user_id', Auth::id())
            ->distinct()
            ->orderByRaw('YEAR(fecha) DESC')
            ->selectRaw('YEAR(fecha) as year')
            ->pluck('year');
    }

    //Contar metas por año.
    private function contarMetas($anio)
    {
        return Meta::where('user_id', Auth::id())
            ->whereYear('fecha', $anio)
            ->count();
    }
    public function calcularAhorroMensual($anio)
    {
        // Obtenemos el nombre de los meses en español
        $meses = $this->meses();

        try {
            // Recuperamos las metas por mes
            $metas = Meta::where('user_id', Auth::id())
                ->whereYear('fecha', $anio)
                ->selectRaw('MONTH(fecha) as mes, SUM(monto_ahorrado) as total_ahorrado')
                ->groupBy('mes')
                ->pluck('total_ahorrado', 'mes'); // Esto nos devuelve un array con mes => total_ahorrado

            // Ahora mapeamos el resultado para asegurar que tenga el nombre del mes
            return collect($meses)->mapWithKeys(function ($nombreMes, $mes) use ($metas) {
                return [
                    $nombreMes => [
                        'total' => $metas->get($mes, 0), // Monto ahorrado para ese mes (o 0 si no hay metas)
                        'ahorrado' => $metas->get($mes, 0), // Asumiendo que quieres mostrar el mismo monto ahorrado
                    ],
                ];
            });

        } catch (\Exception $e) {
            // En caso de error, registramos el error en los logs
            Log::error('Error al calcular el ahorro mensual: ' . $e->getMessage());
            return []; // Devolvemos un array vacío en caso de error
        }
    }

    // Meses del año.
    private function meses()
    {
        return [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
        ];
    }
}
