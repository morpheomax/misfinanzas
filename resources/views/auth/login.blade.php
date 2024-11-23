@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-center text-gray-700">{{ __('Ingresar') }}</h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                {{ __('Introduzca sus credenciales para acceder a su cuenta.') }}
            </p>

            <form method="POST" action="{{ route('login') }}" class="mt-6">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        autocomplete="email" autofocus
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-gray-50 border  rounded-lg focus:ring focus:ring-blue-200 focus:outline-none @error('email') border-red-500 @enderror">
                    @error('email')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Contraseña') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-gray-50 border  rounded-lg focus:ring focus:ring-blue-200 focus:outline-none @error('password') border-red-500 @enderror">
                    @error('password')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <input class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring focus:ring-blue-200"
                            type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="ml-2 text-sm text-gray-600">{{ __('Recordarme') }}</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">
                            {{ __('¿Ha olvidado su contraseña?') }}
                        </a>
                    @endif
                </div>

                <button type="submit"
                    class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring focus:ring-blue-200 focus:outline-none">
                    {{ __('Ingresar') }}
                </button>
            </form>

            <p class="mt-4 text-sm text-center text-gray-600">
                {{ __('¿No tiene cuenta?') }}
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">{{ __('Registrarse') }}</a>
            </p>
        </div>
    </div>
@endsection
