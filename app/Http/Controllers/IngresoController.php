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
        $ingresos = Ingreso::where('user_id', auth()->id())->paginate(10);
        return view('ingresos.index', compact('ingresos'));
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

        $validated['user_id'] = auth()->id(); // Agregar el ID del usuario autenticado

        Ingreso::create($validated);

        return redirect()->route('ingresos.index')->with('success', 'Ingreso agregado correctamente.');
    }

    // Mostrar un ingreso específico
    public function show(Ingreso $ingreso)
    {
        $this->authorize('view', $ingreso); // Usar policy para verificar permisos
        return view('ingresos.show', compact('ingreso'));
    }

    // Mostrar formulario de edición
    public function edit(Ingreso $ingreso)
    {

        $this->authorize('update', $ingreso); // Usar policy para verificar permisos
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
        $this->authorize('delete', $ingreso); // Usar policy para verificar permisos
        $ingreso->delete();

        return redirect()->route('ingresos.index')->with('success', 'Ingreso eliminado correctamente.');
    }
}
