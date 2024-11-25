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
    public function index(Request $request)
    {
        // Ingresos del usuario paginados
        $ingresos = Ingreso::where('user_id', Auth::id())->paginate(10);

        // Sumar ingresos por año, mes y categoría
        $ingresosPorMesYCategoria = $this->ingresosPorMesYCategoria();

        // ingresos agrupados como tabla
        $ingresosAgrupados = $this->ingresosPorMesYCategoriaAgrupados();

        // Sumar ingresos por acumulado anual
        $acumuladoAnual = $this->acumuladoAnual();

        $query = Ingreso::where('user_id', Auth::id());

        // Filtrar por fechas
        if ($request->filled('desde') && $request->filled('hasta')) {
            $query->whereBetween('fecha', [$request->desde, $request->hasta]);
        }

        // Filtrar por palabra clave
        if ($request->filled('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->buscar . '%')
                    ->orWhere('nombre', 'like', '%' . $request->buscar . '%');
            });
        }

        // Obtener resultados paginados
        $ingresos = $query->paginate(10);

        return view('ingresos.index', compact('ingresos', 'ingresosPorMesYCategoria', 'ingresosAgrupados', 'acumuladoAnual'));

    }

    // Calcular ingresos por mes y categoría
    private function ingresosPorMesYCategoria()
    {
        return Ingreso::where('user_id', Auth::id())
            ->selectRaw('YEAR(fecha) as anio, MONTH(fecha) as mes, categoria, SUM(monto) as total_monto')
            ->groupBy('anio', 'mes', 'categoria')
            ->orderBy('anio', 'desc')
            ->orderBy('mes', 'desc')
            ->get();
    }

// Calcular ingresos por mes y categoría agrupados vista de table
    private function ingresosPorMesYCategoriaAgrupados()
    {
        $ingresos = Ingreso::where('user_id', Auth::id())
            ->selectRaw('YEAR(fecha) as anio, MONTH(fecha) as mes, categoria, SUM(monto) as total_monto')
            ->groupBy('anio', 'mes', 'categoria')
            ->orderBy('anio', 'desc')
            ->orderBy('categoria', 'asc')
            ->get();

        // Formatear los datos
        $datosAgrupados = [];
        foreach ($ingresos as $ingreso) {
            $datosAgrupados[$ingreso->anio][$ingreso->categoria][$ingreso->mes] = $ingreso->total_monto;
        }

        return $datosAgrupados;

    }

    // Calcular ingresos por acumulado anual
    private function acumuladoAnual()
    {
        return Ingreso::where('user_id', Auth::id())
            ->selectRaw('YEAR(fecha) as anio, SUM(monto) as total_monto')
            ->groupBy('anio')
            ->orderBy('anio', 'desc')
            ->get();
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

    // Búsqueda de ingresos por palabra clave
    public function search(Request $request)
    {
        $query = $request->input('query');

        $ingresos = Ingreso::where('user_id', Auth::id())
            ->where(function ($q) use ($query) {
                $q->where('nombre', 'like', '%' . $query . '%')
                    ->orWhere('categoria', 'like', '%' . $query . '%');
            })
            ->paginate(10);

        return view('ingresos.index', compact('ingresos'))->with('query', $query);
    }

    // Filtrar ingresos por rango de fechas
    public function filterByDate(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $ingresos = Ingreso::where('user_id', Auth::id())
            ->whereBetween('fecha', [$validated['start_date'], $validated['end_date']])
            ->paginate(10);

        return view('ingresos.index', compact('ingresos'));
    }

    // Duplicar ingresos
    public function duplicate(Ingreso $ingreso)
    {
        $this->authorize('create', $ingreso);

        $newIngreso = $ingreso->replicate();
        $newIngreso->fecha = now(); // Actualizar la fecha si es necesario
        $newIngreso->save();

        return redirect()->route('ingresos.index')->with('success', 'Ingreso duplicado correctamente.');
    }
}
