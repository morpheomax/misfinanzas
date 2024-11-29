<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener el tipo seleccionado desde la solicitud, si existe
        $tipo = $request->input('tipo');

        // Obtener los tipos únicos de la tabla categorias
        $tipos = Categoria::distinct()->pluck('tipo');

        // Obtener las categorías generales con paginación y filtro
        $categoriasGenerales = $this->getCategoriasFiltradas($tipo, null);

        // Obtener las categorías del usuario con paginación y filtro
        $categoriasUsuario = $this->getCategoriasFiltradas($tipo, Auth::id());

        // Devolver las categorías al vista con el tipo seleccionado y los tipos disponibles
        return view('categorias.index', compact('categoriasGenerales', 'categoriasUsuario', 'tipo', 'tipos'));
    }

    /**
     * Función privada para obtener las categorías filtradas por tipo y usuario (si es necesario)
     */
    private function getCategoriasFiltradas($tipo, $userId)
    {
        return Categoria::when($tipo, function ($query) use ($tipo) {
            return $query->where('tipo', $tipo);
        })
            ->when($userId, function ($query) use ($userId) {
                return $query->where('user_id', $userId);
            })
            ->when($userId === null, function ($query) {
                return $query->whereNull('user_id'); // Asegura que no se muestren categorías del usuario si no se pasa el ID de usuario
            })

            ->paginate(10) // Paginación
            ->withQueryString(); // Mantiene los parámetros en la URL
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipos = Categoria::distinct()->pluck('tipo'); // Obtiene valores únicos de 'tipo'
        return view('categorias.create', compact('tipos'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'tipo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
        ]);

        // Crear una categoría
        Categoria::create([
            'tipo' => $request->tipo,
            'nombre' => $request->nombre,
            'user_id' => Auth::id(), // Categoría personalizada para el usuario
        ]);

        return redirect()->route('categorias.index')->with('success', '¡Categoría creada exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        $this->authorize('view', $categoria); // Asegurarse que el usuario tenga acceso
        return view('categorias.show', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        $this->authorize('update', $categoria); // Verificar acceso
        $tipos = Categoria::distinct()->pluck('tipo'); // Obtener tipos únicos
        return view('categorias.edit', compact('categoria', 'tipos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'tipo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $categoria->id,
        ]);

        $this->authorize('update', $categoria);

        // Actualizar la categoría
        $categoria->update([
            'tipo' => $request->tipo,
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('categorias.index')->with('success', '¡Categoría actualizada exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        $this->authorize('delete', $categoria);

        // Eliminar la categoría
        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', '¡Categoría eliminada exitosamente!');
    }

    /**
     * API: Obtener categorías por tipo.
     */
    public function getCategorias(Request $request)
    {
        $tipo = $request->query('tipo');

        // Obtener categorías del usuario actual y generales por tipo
        $categorias = Categoria::where('tipo', $tipo)
            ->where(function ($query) {
                $query->where('user_id', Auth::id())
                    ->orWhereNull('user_id'); // Categorías generales
            })
            ->get(['id', 'nombre']);

        return response()->json($categorias);
    }
}
