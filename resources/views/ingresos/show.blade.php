@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6 max-w-4xl mx-auto">
            <h1 class="text-2xl font-semibold text-gray-800 mb-4">Detalle del Ingreso</h1>
            <ul class="space-y-3">
                <li class="flex justify-between text-gray-600">
                    <span class="font-medium">Nombre:</span>
                    <span>{{ $ingreso->nombre }}</span>
                </li>
                <li class="flex justify-between text-gray-600">
                    <span class="font-medium">Categoría:</span>
                    <span>{{ $ingreso->categoria }}</span>
                </li>
                <li class="flex justify-between text-gray-600">
                    <span class="font-medium">Monto:</span>
                    <span>{{ '$' . number_format($ingreso->monto, 0, '', '.') }}</span>
                </li>
                <li class="flex justify-between text-gray-600">
                    <span class="font-medium">Fecha:</span>
                    <span>{{ \Carbon\Carbon::parse($ingreso->fecha)->format('d/m/Y') }}</span>
                </li>
            </ul>
            <div class="mt-6 flex justify-between space-x-2">
                <a href="{{ route('ingresos.index') }}"
                    class="bg-gray-500 text-white hover:bg-gray-600 px-4 py-2 rounded-lg transition duration-200 w-full sm:w-auto">Volver</a>
                <a href="{{ route('ingresos.edit', $ingreso->id) }}"
                    class="bg-yellow-500 text-white hover:bg-yellow-600 px-4 py-2 rounded-lg transition duration-200 w-full sm:w-auto">Editar</a>
                <form action="{{ route('ingresos.destroy', $ingreso->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 text-white hover:bg-red-600 px-4 py-2 rounded-lg transition duration-200 w-full sm:w-auto"
                        onclick="return confirm('¿Estás seguro de eliminar este ingreso?')">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
