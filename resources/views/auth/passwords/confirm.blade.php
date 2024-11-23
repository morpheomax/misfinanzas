@extends('layouts.app')

@section('content')
    <div class="container py-12">
        <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-8">
            <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">{{ __('Confirm Password') }}</h2>

            <p class="text-sm text-center text-gray-600 mb-6">
                {{ __('Por favor, confirme su contraseña antes de continuar.') }}</p>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-600 mb-2">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                        {{ __('Confirme la contraseña') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-600 hover:text-indigo-900" href="{{ route('password.request') }}">
                            {{ __('¿Olvidó su contraseña?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
