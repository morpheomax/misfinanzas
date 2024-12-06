<?php

namespace App\Http\Controllers;

use App\Models\Meta;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MetaController extends Controller
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

        // Obtener metas filtradas por el usuario
        $query = $this->filtrosMeta($request);

        $metas = $query->paginate(10);

        // Datos para las estadísticas
        $metasCumplidas = $this->metasCumplidas($anio);
        $metasPendientes = $this->metasPendientes($anio);
        $metasPorEstado = $this->metasPorEstado($anio);
        $metasPorMes = $this->metasPorMes($anio);
        $metasPorAnio = $this->metasPorAnio();
        $metasProgreso = $this->metasProgreso();

        // Convertir los números de los meses a nombres
        $meses = $this->meses();
        $metasPorMes = $metasPorMes->mapWithKeys(function ($total, $mes) use ($meses) {
            return [$meses[$mes] => $total]; // Mapear el mes numérico a su nombre
        });

        // Extraes las claves (meses) y los valores (totales)
        $meses = $metasPorMes->keys(); // Meses (las claves)
        $totales = $metasPorMes->values(); // Totales (los valores)

        // Si la solicitud es AJAX, devolver solo los componentes necesarios
        if ($request->ajax()) {
            $metasCumplidasView = view('metas.cumplidas', ['metasCumplidas' => $metasCumplidas])->render();
            $metasPendientes = view('metas.pendientes', ['metasPendientes' => $metasPendientes])->render();
            $metasPorEstado = view('metas.estado', ['metasPorEstado' => $metasPorEstado])->render();
            $metasPorMesView = view('metas.por-mes', ['metasPorMes' => $metasPorMes])->render();

            return response()->json([
                'metasCumplidas' => $metasCumplidasView,
                'metasPendientes' => $metasPendientes,
                'metasPorEstado' => $metasPorEstado,
                'metasPorMes' => $metasPorMesView,
            ]);
        }

        return view('metas.index', [
            'metas' => $metas,
            'anio' => $anio,
            'aniosDisponibles' => $aniosDisponibles,
            'metasCumplidas' => $metasCumplidas,
            'metasPendientes' => $metasPendientes,
            'metasPorEstado' => $metasPorEstado,
            'metasPorMes' => $metasPorMes,
            'metasPorAnio' => $metasPorAnio,
            'metasProgreso' => $metasProgreso,

        ]);
    }

    /**
     * Filtros para la consulta de metas.
     */
    private function filtrosMeta(Request $request)
    {
        $query = Meta::where('user_id', Auth::id());

        // Filtro por estado de la meta
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

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

    /**
     * Obtener los años disponibles para el filtro.
     */
    private function aniosDisponibles()
    {
        return Meta::where('user_id', Auth::id())
            ->distinct()
            ->orderByRaw('YEAR(fecha) DESC')
            ->selectRaw('YEAR(fecha) as year')
            ->pluck('year');
    }

    /**
     * Obtener las metas cumplidas en un año.
     */
    private function metasCumplidas($anio)
    {
        return Meta::where('user_id', Auth::id())
            ->whereYear('fecha', $anio)
            ->where('estado', 'cumplida')
            ->count();
    }
    /**
     * Obtener las metas cumplidas en un año.
     */
    private function metasPendientes($anio)
    {
        return Meta::where('user_id', Auth::id())
            ->whereYear('fecha', $anio)
            ->where('estado', 'pendiente')
            ->count();
    }

    private function metasPorEstado($anio)
    {
        // Consulta para obtener la cantidad de metas por estado
        $metasPorEstado = Meta::selectRaw('estado, COUNT(*) as total')
            ->whereYear('fecha', $anio)
            ->where('user_id', Auth::id()) // Filtrar por el usuario logueado
            ->groupBy('estado')
            ->pluck('total', 'estado');

// Asegurarse de incluir los estados pendientes y cumplidas con 0 por defecto
        return collect(['pendiente' => 0, 'cumplida' => 0])->merge($metasPorEstado);
    }

    /**
     * Obtener metas por mes.
     */
    private function metasPorMes($anio)
    {
        $metasPorMes = Meta::selectRaw('MONTH(fecha) as mes, COUNT(*) as total')

            ->whereYear('fecha', $anio)
            ->where('user_id', Auth::id()) // Filtramos por el ID del usuario logueado
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes');

        // Crear un array con 0 para todos los meses, si no hay datos para ese mes
        $meses = collect(range(1, 12))->mapWithKeys(function ($mes) use ($metasPorMes) {
            return [$mes => $metasPorMes->get($mes, 0)];
        });

        return $meses;
    }

    private function metasPorAnio()
    {
        // Suponiendo que tienes un modelo 'Meta' con campos 'anio' y 'cumplida'
        $metasPorAnio = Meta::selectRaw('YEAR(created_at) as anio, COUNT(*) as total')
            ->groupBy('anio')
            ->get();

    }

    //metas cumplidas
    private function metasProgreso()
    {
        // Obtener las metas cumplidas por mes
        return Meta::selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->where('estado', 'cumplida') // o 'cumplida' dependiendo de tu base de datos
            ->groupBy('mes')
            ->get(); // Esto devuelve una colección
    }

    /**
     * Obtener nombres de los meses.
     */
    private function meses()
    {
        return [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('metas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos
        $data = $request->validate([
            'estado' => 'required|in:pendiente,cumplida',
            'nombre' => 'required|string|max:255',
            'monto' => 'required|numeric',
            'monto_ahorrado' => 'required|numeric',
            'fecha' => 'required|date',
        ]);

        // Crear la meta
        Meta::create([
            'nombre' => $data['nombre'],
            'monto' => $data['monto'],
            'monto_ahorrado' => $data['monto_ahorrado'],
            'fecha' => $data['fecha'],
            'user_id' => Auth::id(),
            'estado' => 'pendiente', // Estado inicial
        ]);

        return redirect()->route('metas.index')->with('swal', [
            'title' => '¡Meta creada!',
            'text' => 'Tu meta ha sido registrada exitosamente.',
            'icon' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meta $meta)
    {
        $this->authorize('update', $meta);

        return view('metas.edit', compact('meta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meta $meta)
    {
        $this->authorize('update', $meta);

        $data = $request->validate([
            'estado' => 'required|in:pendiente,cumplida',
            'nombre' => 'required|string|max:255',
            'monto' => 'required|numeric',
            'monto_ahorrado' => 'required|numeric',
            'fecha' => 'required|date',
        ]);

        $meta->update($data);

        return redirect()->route('metas.index')->with('swal', [
            'title' => '¡Meta actualizada!',
            'text' => 'La meta ha sido actualizada exitosamente.',
            'icon' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meta $meta)
    {
        $this->authorize('delete', $meta);

        $meta->delete();

        return redirect()->route('metas.index')->with('swal', [
            'title' => '¡Meta eliminada!',
            'text' => 'La meta fue eliminada correctamente.',
            'icon' => 'success',
        ]);
    }
}
