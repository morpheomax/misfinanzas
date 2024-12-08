@extends('layouts.app')
@section('title', 'Edición de Información')

@section('content')
    <div class="text-center mt-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Editar Perfil</h1>
        <div class="container mx-auto p-6 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Formulario para editar perfil -->
            <div class="w-full bg-white shadow-lg rounded-lg p-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Información de Perfil</h2>
                <form action="{{ route('user.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6">
                        <div class="flex flex-col space-y-2">
                            <label class="text-lg font-semibold text-gray-700" for="name">Nombre</label>
                            <input type="text" name="name" id="name" value="{{ $user->name }}"
                                class="border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        </div>
                        <div class="flex flex-col space-y-2">
                            <label class="text-lg font-semibold text-gray-700" for="lastname">Apellido</label>
                            <input type="text" name="lastname" id="lastname" value="{{ $user->lastname }}"
                                class="border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        </div>
                        <div class="flex flex-col space-y-2">
                            <label class="text-lg font-semibold text-gray-700" for="country">País</label>
                            <input type="text" name="country" id="country" value="{{ $user->country }}"
                                class="border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        </div>
                        <div class="flex flex-col space-y-2">
                            <label class="text-lg font-semibold text-gray-700" for="city">Ciudad</label>
                            <input type="text" name="city" id="city" value="{{ $user->city }}"
                                class="border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <button type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white py-3 px-8 rounded-lg transition duration-300 transform hover:scale-105">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>

            <!-- Sección de Cambio de Contraseña -->
            <div class="w-full bg-white shadow-lg rounded-lg p-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Cambiar Contraseña</h2>
                <form action="{{ route('user.changePassword', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div class="flex flex-col space-y-2">
                            <label class="text-lg font-semibold text-gray-700" for="current_password">Contraseña
                                Actual</label>
                            <input type="password" name="current_password" id="current_password"
                                class="border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        </div>
                        <div class="flex flex-col space-y-2">
                            <label class="text-lg font-semibold text-gray-700" for="new_password">Nueva Contraseña</label>
                            <input type="password" name="new_password" id="new_password"
                                class="border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        </div>
                        <div class="flex flex-col space-y-2">
                            <label class="text-lg font-semibold text-gray-700" for="new_password_confirmation">Confirmar
                                Contraseña</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                class="border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <button type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white py-3 px-8 rounded-lg transition duration-300 transform hover:scale-105">
                            Cambiar Contraseña
                        </button>
                    </div>
                </form>
            </div>

            <!-- Sección para desactivar cuenta -->
            <div class="w-full bg-white shadow-lg rounded-lg p-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Desactivar Cuenta</h2>
                <form action="{{ route('user.deactivate', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mt-6 text-center">
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white py-3 px-8 rounded-lg transition duration-300 transform hover:scale-105">
                            Desactivar Cuenta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
