@extends('layouts.app')

@section('title', 'Creación de Categorías')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg">
            <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Crear Nueva Categoría</h1>

            <form action="{{ route('categorias.store') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                    <select name="tipo" id="tipo"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                        <option value="">Selecciona un tipo</option>
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo }}">{{ ucfirst($tipo) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-6">
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre de la Categoría</label>
                    <input type="text" name="nombre" id="nombre"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                </div>



                <div class="flex justify-between">
                    <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition">Guardar</button>
                    <a href="{{ route('categorias.index') }}"
                        class="px-6 py-2 bg-gray-500 text-white rounded-lg font-semibold hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 transition">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
