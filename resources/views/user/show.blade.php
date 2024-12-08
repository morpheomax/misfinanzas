@extends('layouts.app')

@section('title', 'Información de tu cuenta')

@section('content')
    <div class="container mx-auto p-6">
        <!-- Título del Perfil -->
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Tu Perfil</h1>

        <!-- Contenedor de Información -->
        <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Información del Usuario -->
                <div class="flex flex-col space-y-4">
                    <p class="text-lg text-gray-700"><strong class="font-semibold">Nombre:</strong> {{ $user->name }}</p>
                    <p class="text-lg text-gray-700"><strong class="font-semibold">Apellido:</strong> {{ $user->lastname }}
                    </p>
                    <p class="text-lg text-gray-700"><strong class="font-semibold">País:</strong> {{ $user->country }}</p>
                    <p class="text-lg text-gray-700"><strong class="font-semibold">Ciudad:</strong> {{ $user->city }}</p>
                    <p class="text-lg text-gray-700"><strong class="font-semibold">Email:</strong> {{ $user->email }}</p>
                    <p class="text-lg text-gray-700"><strong class="font-semibold">Fecha de Registro:</strong>
                        {{ $user->created_at->format('d/m/Y') }}</p>
                </div>

                <!-- Foto de Perfil (Opcional) -->
                <div class="flex justify-center sm:justify-end items-center flex-col space-y-4">
                    <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($user->email))) }}"
                        alt="Foto de Perfil"
                        class="w-32 h-32 rounded-full object-cover border-4 border-yellow-500 shadow-lg">
                    <p class="text-sm text-center text-gray-600 mt-2">¿Aún no tienes un avatar? Puedes crear uno gratuito en
                        Gravatar, y
                        usarlo en otras aplicaciones también.</p>
                    <a href="https://gravatar.com" target="_blank"
                        class="text-sm bg-yellow-400 hover:bg-yellow-600 text-white py-2 px-4 rounded-lg transition duration-300 transform hover:scale-105">
                        Crear Avatar en Gravatar
                    </a>
                </div>
            </div>

            <!-- Botón de Editar Perfil -->
            <div class="mt-8 text-center">
                <a href="{{ route('user.edit', $user->id) }}"
                    class="bg-emerald-600 hover:bg-emerald-800 text-white py-2 px-6 rounded-lg transition duration-300 transform hover:scale-105">
                    Editar Perfil
                </a>
            </div>
        </div>
    </div>
@endsection
