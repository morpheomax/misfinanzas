@extends('layouts.app')

@section('title', 'Categorías')

@section('content')
    <div class="container">
        <h1>Mis Categorías</h1>

        <!-- Filtro por tipo -->
        <form method="GET" action="{{ route('categorias.index') }}" class="mb-6">
            <div class="flex items-center space-x-4">
                <label for="tipo" class="text-lg text-gray-700">Filtrar por tipo</label>
                <select name="tipo"
                    class="form-select bg-white border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    onchange="this.form.submit()">
                    <option value="">Selecciona un tipo</option>
                    @foreach ($tipos as $tipoOpcion)
                        <option value="{{ $tipoOpcion }}" {{ $tipo == $tipoOpcion ? 'selected' : '' }}>
                            {{ ucfirst($tipoOpcion) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        <!-- Categorías Generales (no modificables) -->
        <h3>Categorías Generales</h3>
        @if ($categoriasGenerales->count())
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categoriasGenerales as $categoria)
                        <tr>
                            <td>{{ $categoria->nombre }}</td>
                            <td>{{ ucfirst($categoria->tipo) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No hay categorías generales disponibles.</p>
        @endif
        <!-- Paginación -->
        <div class="mt-4">
            {{ $categoriasGenerales->links() }} <!-- Aquí agregamos los enlaces de paginación -->
        </div>

        <!-- Categorías Creadas por el Usuario -->
        <h3>Categorías Creadas por Ti</h3>


        <a href="{{ route('categorias.create') }}">Crea una aquí</a>


        @if ($categoriasUsuario->count())
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categoriasUsuario as $categoria)
                        <tr>
                            <td>{{ $categoria->nombre }}</td>
                            <td>{{ ucfirst($categoria->tipo) }}</td>
                            <td>
                                <a href="{{ route('categorias.edit', $categoria) }}"
                                    class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('categorias.destroy', $categoria) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Paginación -->
            <div class="mt-4">
                {{ $categoriasUsuario->links() }}
            </div>
        @else
            <p>No has creado ninguna categoría aún.</p>
        @endif
    </div>
@endsection
