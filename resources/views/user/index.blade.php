@extends('layouts.app')
@section('title', 'Información de tu cuenta')

@section('content')
    <div class="container mx-auto px-4 py-8">
        {{-- Información del administrador --}}
        @if (Auth::user()->role == 'admin')
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
                <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Información de tu cuenta</h1>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <p><strong class="text-gray-600 dark:text-gray-400">Nombre:</strong> {{ Auth::user()->name }}</p>
                    <p><strong class="text-gray-600 dark:text-gray-400">Apellido:</strong> {{ Auth::user()->lastname }}</p>
                    <p><strong class="text-gray-600 dark:text-gray-400">País:</strong> {{ Auth::user()->country }}</p>
                    <p><strong class="text-gray-600 dark:text-gray-400">Ciudad:</strong> {{ Auth::user()->city }}</p>
                </div>
            </div>
        @endif

        {{-- Información de usuarios registrados --}}
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Información de Usuarios Registrados</h1>
            <p class="text-gray-600 dark:text-gray-400">
                Hay <strong>{{ $users->count() }}</strong> usuarios registrados.
            </p>

            @if ($users->isEmpty())
                <p class="text-gray-600 dark:text-gray-400">No hay usuarios registrados.</p>
            @endif

            @if ($users->count() > 0)
                <form action="{{ route('user.index') }}" method="GET" class="mt-4 flex gap-2">
                    <input type="text" name="search" placeholder="Buscar por nombre o email"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:placeholder-gray-400">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-300">
                        Buscar
                    </button>
                </form>
            @endif
        </div>

        {{-- Lista de usuarios --}}
        @if ($users->count() > 0)
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Lista de Usuarios</h2>
                @if ($users->count() > 10)
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Mostrando los primeros 10 resultados.</p>
                @endif
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-200 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-gray-600 dark:text-gray-300">Nombre</th>
                                <th class="px-4 py-2 text-gray-600 dark:text-gray-300">Email</th>
                                <th class="px-4 py-2 text-gray-600 dark:text-gray-300">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100">{{ $user->name }}</td>
                                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100">{{ $user->email }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('user.edit', $user) }}" class="text-blue-500 hover:underline">
                                            Editar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
