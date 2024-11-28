@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-6 text-gray-800">Editar Ingreso</h1>
        <!-- Aquí la ruta es correcta y @method('PUT') es necesaria para indicar la actualización -->
        <form action="{{ route('ingresos.update', $ingreso->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT') <!-- Método PUT para actualizar el recurso -->

            <!-- Contenedor de campos organizados en columna para pantallas pequeñas, en fila para pantallas medianas y grandes -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                <!-- Nombre -->
                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="nombre" id="nombre"
                        class="mt-2 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('nombre', $ingreso->nombre) }}" required>
                    @error('nombre')
                        <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Categoría -->
                <div class="mb-4">
                    <label for="categoria" class="block text-sm font-medium text-gray-700">Categoría</label>
                    <input type="text" name="categoria" id="categoria"
                        class="mt-2 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('categoria', $ingreso->categoria) }}" required>
                    @error('categoria')
                        <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Monto -->
                <div class="mb-4">
                    <label for="monto" class="block text-sm font-medium text-gray-700">Monto</label>
                    <input type="number" name="monto" id="monto"
                        class="mt-2 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('monto', $ingreso->monto) }}" required>
                    @error('monto')
                        <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Fecha -->
                <div class="mb-4">
                    <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                    <input type="date" name="fecha" id="fecha"
                        class="mt-2 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('fecha', $ingreso->fecha) }}" required>
                    @error('fecha')
                        <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <!-- Botones -->
            <div class="flex justify-between mt-6">
                <!-- Botón Volver -->
                <a href="{{ route('ingresos.index') }}"
                    class="w-full sm:w-auto bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-3 px-6 rounded-md text-center transition duration-300 ease-in-out">
                    Volver al Listado
                </a>

                <!-- Botón Actualizar -->
                <button type="submit"
                    class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-md transition duration-300 ease-in-out">
                    Actualizar Ingreso
                </button>
            </div>
        </form>
    </div>
@endsection
