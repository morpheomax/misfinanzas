@extends('layouts.app')

@section('title', 'Información no encontrada')

@section('content')
    <div class="bg-gray-100 flex items-center justify-center min-h-screen">
        <div class="text-center p-6 bg-white shadow-lg rounded-lg max-w-md mx-auto">
            <div class="flex justify-center">
                <img src="{{ asset('images/404-error.svg') }}" alt="Página No Encontrada" class="h-32 w-32">
            </div>
            <h1 class="text-4xl font-bold text-gray-800 mt-4">404</h1>
            <p class="text-gray-600 mt-2 text-lg">
                ¡Ups! La página que buscas no existe.
            </p>
            <p class="text-gray-500 mt-1 text-sm">
                Puede que haya sido eliminada, o que la dirección esté incorrecta.
            </p>
            <div class="mt-6">
                <a href="{{ route('ingresos.index') }}"
                    class="px-6 py-2 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2">
                    Volver al inicio
                </a>
            </div>
        </div>
    </div>
@endsection
