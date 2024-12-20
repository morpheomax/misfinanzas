@extends('layouts.app')

@section('title', 'Categorías')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Título principal -->
        <h1 class="text-4xl font-semibold text-gray-800 mb-8">Mis Categorías</h1>

        <!-- Filtro por tipo -->
        <form method="GET" action="{{ route('categorias.index') }}"
            class="mb-6 flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4">
            <label for="tipo" class="text-lg text-gray-700">Filtrar por tipo</label>
            <select name="tipo"
                class="form-select bg-white border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-auto"
                onchange="this.form.submit()">
                <option value="">Selecciona un tipo</option>
                @foreach ($tipos as $tipoOpcion)
                    <option value="{{ $tipoOpcion }}" {{ $tipo == $tipoOpcion ? 'selected' : '' }}>
                        {{ ucfirst($tipoOpcion) }}
                    </option>
                @endforeach
            </select>
        </form>

        <!-- Categorías Generales (no modificables) -->
        <div class="mb-8">
            <h3 class="text-3xl font-semibold text-gray-800 mb-6">Categorías Generales</h3>
            @if ($categoriasGenerales->count())
                <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                    <table class="min-w-full table-auto text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 text-left font-semibold text-gray-700">Tipo</th>
                                <th class="py-3 px-4 text-left font-semibold text-gray-700">Nombre</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categoriasGenerales as $categoria)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 text-gray-600">{{ ucfirst($categoria->tipo) }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ $categoria->nombre }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-600">No hay categorías generales disponibles.</p>
            @endif
        </div>

        <!-- Paginación -->
        <div class="mb-8">
            {{ $categoriasGenerales->links() }}
        </div>

        <!-- Categorías Creadas por el Usuario -->
        <div>
            <h3 class="text-3xl font-semibold text-gray-800 mb-6">Categorías Creadas por Ti</h3>

            <!-- Botón para crear una nueva categoría -->
            <a href="{{ route('categorias.create') }}"
                class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg text-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 mb-6 transition duration-300">
                Crear una nueva categoría
            </a>

            @if ($categoriasUsuario->count())
                <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 text-left font-semibold text-gray-700">Nombre</th>
                                <th class="py-3 px-4 text-left font-semibold text-gray-700">Tipo</th>
                                <th class="py-3 px-4 text-left font-semibold text-gray-700">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categoriasUsuario as $categoria)
                                <tr class="hover:bg-gray-50">
                                    <td class=" px-3 text-gray-600">{{ $categoria->nombre }}</td>
                                    <td class=" px-3 text-gray-600">{{ ucfirst($categoria->tipo) }}</td>
                                    <td class=" px-3">
                                        <div class="gap-4 flex  items-center">
                                            <a href="{{ route('categorias.edit', $categoria) }}"
                                                class="inline-block px-4 py-2 bg-yellow-400 text-white rounded-lg text-sm font-semibold hover:bg-yellow-500 transition duration-300">
                                                Editar
                                            </a>
                                            <div class="flex justify-center items-center mt-4">
                                                <form action="{{ route('categorias.destroy', $categoria) }}" method="POST"
                                                    id="delete-form-{{ $categoria->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        class="inline-block px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition duration-300"
                                                        type="button" onclick="confirmDelete({{ $categoria->id }})">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-6">
                    {{ $categoriasUsuario->links() }}
                </div>
            @else
                <p class="text-gray-600">No has creado ninguna categoría aún.</p>
            @endif
        </div>
    </div>
@endsection

<!-- SweetAlert -->
@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
@endif

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Estás seguro de eliminar esta categoría?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
