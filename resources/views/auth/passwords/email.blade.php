@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-8">
            <h2 class="text-2xl font-semibold text-center mb-6">{{ __('Restablecer Contraseña') }}</h2>

            @if (session('status'))
                <div class="alert alert-success mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <label for="email"
                        class="block text-sm font-medium text-gray-700">{{ __('Correo Electrónico') }}</label>
                    <input id="email" type="email"
                        class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                        {{ __('Enviar Enlace para Restablecer Contraseña') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
