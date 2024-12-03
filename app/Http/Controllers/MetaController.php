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
        $userId = Auth::id();
        $filtroAnio = $request->input('anio', now()->year);

        // Datos principales
        $metas = Meta::where('user_id', $userId)->paginate(10);
        $metasPorMes = $this->metasAgrupadasPorMes($filtroAnio);
        $totalesPorAnio = $this->contarMetas($filtroAnio);
        $totalesMensuales = $this->calcularAhorroMensual($filtroAnio);
        $aniosDisponibles = $this->obtenerAniosDisponibles($userId);

        return view('metas.index', compact(
            'metas',
            'metasPorMes',
            'totalesPorAnio',
            'totalesMensuales',
            'aniosDisponibles',
            'filtroAnio'
        ));
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
        $validated = $this->validateMeta($request);

        $validated['user_id'] = Auth::id();
        Meta::create($validated);

        return redirect()->route('metas.index')->with('success', 'Meta creada exitosamente.');
    }

    /**
     * Show the specified resource.
     */
    public function show(Meta $meta)
    {
        $this->authorize('view', $meta);
        return view('metas.show', compact('meta'));
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

        $validated = $this->validateMeta($request);
        $meta->update($validated);

        return redirect()->route('metas.index')->with('success', 'Meta actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meta $meta)
    {
        $this->authorize('delete', $meta);
        $meta->delete();

        return redirect()->route('metas.index')->with('success', 'Meta eliminada exitosamente.');
    }

    /**
     * Validar los datos de una meta.
     */
    private function validateMeta(Request $request)
    {
        return $request->validate([
            'nombre' => 'required|string|max:255',
            'monto' => 'required|numeric',
            'monto_ahorrado' => 'required|numeric',
            'fecha' => 'required|date',
        ]);
    }

    /**
     * Agrupar metas por mes para un año específico.
     */
    private function metasAgrupadasPorMes($anio)
    {
        $meses = $this->meses();
        $metas = Meta::where('user_id', Auth::id())
            ->whereYear('fecha', $anio)
            ->get()
            ->groupBy(fn($meta) => (int) $meta->fecha->format('m'));

        return collect($meses)->mapWithKeys(fn($nombreMes, $numMes) => [
            $nombreMes => $metas->get($numMes, collect([]))
        ]);
    }

    /**
     * Obtener los años disponibles para el filtro.
     */
    private function obtenerAniosDisponibles($userId)
    {
        return Meta::where('user_id', $userId)
            ->selectRaw('YEAR(fecha) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
    }

    /**
     * Contar metas por año.
     */
    private function contarMetas($anio)
    {
        return Meta::where('user_id', Auth::id())
            ->whereYear('fecha', $anio)
            ->count();
    }

    /**
     * Calcular ahorro mensual para un año específico.
     */
    private function calcularAhorroMensual($anio)
    {
        return Meta::where('user_id', Auth::id())
            ->whereYear('fecha', $anio)
            ->get()
            ->groupBy(fn($meta) => (int) $meta->fecha->format('m'))
            ->map(fn($metas) => $metas->sum('monto_ahorrado'));
    }

    /**
     * Meses del año.
     */
    private function meses()
    {
        return [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
        ];
    }
}
