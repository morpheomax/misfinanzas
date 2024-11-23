@extends('layouts.app')

@section('content')
    <div class="container px-4 py-12">
        <div class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-8">
            <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">
                {{ __('Verifique su Dirección de Correo Electrónico') }}</h2>

            @if (session('resent'))
                <div class="alert alert-success bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6">
                    {{ __('Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.') }}
                </div>
            @endif

            <p class="text-gray-600 mb-4">
                {{ __('Antes de continuar, revise su correo electrónico para obtener un enlace de verificación.') }}
            </p>
            <p class="text-gray-600">
                {{ __('Si no recibió el correo electrónico') }},
            <form class="inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="text-indigo-600 hover:text-indigo-800 focus:outline-none">
                    {{ __('Haga clic aquí para solicitar otro') }}
                </button>.
            </form>
            </p>
        </div>
    </div>
@endsection
