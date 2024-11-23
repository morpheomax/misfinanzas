<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IngresoController extends Controller
{
    use AuthorizesRequests; // Incluir el trait para usar authorize

    // Mostrar lista de ingresos
    public function index()
    {
        // Usar Auth::id() para mantener consistencia
        $ingresos = Ingreso::where('user_id', Auth::id())->paginate(10);

        // Cálculos por mes, año y categoría
        $mesActual = now()->format('m');
        $anioActual = now()->format('Y');

        // Sumar ingresos por año, mes y categoría
        $ingresosPorMesYCategoria = Ingreso::where('user_id', Auth::id())
            ->selectRaw('YEAR(fecha) as anio, MONTH(fecha) as mes, categoria, SUM(monto) as total_monto')
            ->groupBy('anio', 'mes', 'categoria')
            ->get();

        // Sumar ingresos por acumulado anual
        $acumuladoAnual = Ingreso::where('user_id', Auth::id())
            ->selectRaw('YEAR(fecha) as anio, SUM(monto) as total_monto')
            ->groupBy('anio')
            ->get();

        return view('ingresos.index', compact('ingresos', 'mesActual', 'anioActual', 'acumuladoAnual', 'ingresosPorMesYCategoria'));

    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('ingresos.create');
    }

    // Guardar un nuevo ingreso
    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoria' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
        ]);

        $validated['user_id'] = Auth::id(); // Asegurar que el ID del usuario esté presente

        Ingreso::create($validated);

        return redirect()->route('ingresos.index')->with('success', 'Ingreso agregado correctamente.');
    }

    // Mostrar un ingreso específico
    public function show(Ingreso $ingreso)
    {
        $this->authorize('view', $ingreso);
        return view('ingresos.show', compact('ingreso'));
    }

    // Mostrar formulario de edición
    public function edit(Ingreso $ingreso)
    {
        $this->authorize('update', $ingreso);
        return view('ingresos.edit', compact('ingreso'));
    }

    // Actualizar un ingreso
    public function update(Request $request, Ingreso $ingreso)
    {
        $this->authorize('update', $ingreso);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
        ]);

        $ingreso->update($validated);

        return redirect()->route('ingresos.index')->with('success', 'Ingreso actualizado exitosamente.');
    }

    // Eliminar un ingreso
    public function destroy(Ingreso $ingreso)
    {
        $this->authorize('delete', $ingreso);
        $ingreso->delete();

        return redirect()->route('ingresos.index')->with('success', 'Ingreso eliminado correctamente.');
    }
}
