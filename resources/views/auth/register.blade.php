@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="px-6 py-4 text-center border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ __('Registrar') }}</h2>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nombre -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Nombre') }}
                        </label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                            autocomplete="name" autofocus
                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-gray-50 border  rounded-lg focus:ring focus:ring-blue-200 focus:outline-none @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Email') }}
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            autocomplete="email"
                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-gray-50 border  rounded-lg focus:ring focus:ring-blue-200 focus:outline-none @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Contraseña') }}
                        </label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-gray-50 border  rounded-lg focus:ring focus:ring-blue-200 focus:outline-none @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div class="mb-4">
                        <label for="password-confirm" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Confirmar Contraseña') }}
                        </label>
                        <input id="password-confirm" type="password" name="password_confirmation" required
                            autocomplete="new-password"
                            class="w-full px-4 py-2 mt-2 bg-gray-50 border  rounded-lg dark:border-gray-600 dark:bg-gray-700 text-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <!-- Botón Registrar -->
                    <div class="mt-6">
                        <button type="submit"
                            class="w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Registrar') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
