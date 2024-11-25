@extends('layouts.app')

@section('title', 'Control de Finanzas Personales')


@section('content')

    <!-- Hero Section -->
    <header class="relative bg-gradient-to-r from-blue-500 to-teal-500 text-white py-32 text-center">
        <div class="container mx-auto px-4 relative z-10">
            <h1 class="text-5xl font-bold leading-tight">
                Toma Control de tus Finanzas Personales
            </h1>
            <p class="mt-4 text-xl font-medium">
                Organiza tus ingresos, gastos y metas. ¡Conviértete en el dueño de tu futuro financiero!
            </p>
            <a href="{{ route('login') }}"
                class="mt-6 inline-block px-8 py-4 bg-blue-800 text-white font-semibold text-lg rounded-lg hover:bg-blue-900 transform transition duration-300 hover:scale-105">
                Comenzar Ahora
            </a>
        </div>
        <!-- Imagen de fondo con opacidad aplicada solo a la imagen -->
        <div class="absolute inset-0 opacity-60 bg-cover bg-center"
            style="background-image: url('{{ asset('images/hero_image.jpg') }}');"></div>
    </header>


    <!-- Visión General de la Herramienta -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-semibold text-gray-900 dark:text-white">
                ¿Por qué usar nuestra herramienta?
            </h2>
            <p class="mt-4 text-lg text-gray-700 dark:text-gray-300">
                ¡Tu mejor aliado para tomar decisiones financieras inteligentes! Ahorra tiempo y optimiza tus gastos.
            </p>
        </div>
    </section>

    <!-- Sección de Beneficios -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- Ingresos -->
            <div class="bg-blue-100 rounded-lg shadow-lg p-8 text-center transform transition duration-300 hover:scale-105">
                <h3 class="text-xl font-semibold text-blue-900">Gestión de Ingresos</h3>
                <p class="mt-4 text-gray-600">
                    Lleva un registro detallado de tus entradas de dinero. Visualiza tus fuentes de ingresos y toma
                    decisiones más sabias.
                </p>
            </div>

            <!-- Egresos -->
            <div class="bg-teal-100 rounded-lg shadow-lg p-8 text-center transform transition duration-300 hover:scale-105">
                <h3 class="text-xl font-semibold text-teal-900">Control de Egresos</h3>
                <p class="mt-4 text-gray-600">
                    Mantén un control preciso de tus gastos mensuales. ¡Descubre oportunidades para ahorrar!
                </p>
            </div>

            <!-- Metas -->
            <div
                class="bg-yellow-100 rounded-lg shadow-lg p-8 text-center transform transition duration-300 hover:scale-105">
                <h3 class="text-xl font-semibold text-yellow-900">Alcance de Metas</h3>
                <p class="mt-4 text-gray-600">
                    Define tus metas financieras y hazlas realidad. Realiza un seguimiento detallado y ajusta tus
                    estrategias.
                </p>
            </div>
        </div>
    </section>

    <!-- Visualización de Resultados -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-semibold text-gray-900 dark:text-white">Tu Progreso al Instante</h2>
            <p class="mt-4 text-lg text-gray-700 dark:text-gray-300">
                Visualiza tus resultados de manera clara con gráficos interactivos y análisis detallados.
            </p>
        </div>
        <div class="container mx-auto px-6 mt-8">
            <!-- Aquí puedes incluir un gráfico de ejemplo -->
            <img src="path_to_graph_image.jpg" alt="Gráfico de Finanzas" class="mx-auto rounded-lg shadow-lg">
        </div>
    </section>

    <!-- Testimonios -->
    <section class="py-16 bg-blue-50">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-semibold text-gray-900 dark:text-white">Lo que dicen nuestros usuarios</h2>
            <div class="flex justify-center mt-8 space-x-4">
                <!-- Testimonio 1 -->
                <div class="bg-white shadow-lg rounded-lg p-6 w-80">
                    <p class="text-lg text-gray-700">"Gracias a esta herramienta, pude ordenar mis finanzas y ahorrar para
                        mi futuro. ¡Totalmente recomendada!"</p>
                    <p class="mt-4 text-gray-500">- Juan Pérez</p>
                </div>
                <!-- Testimonio 2 -->
                <div class="bg-white shadow-lg rounded-lg p-6 w-80">
                    <p class="text-lg text-gray-700">"Lo mejor es la visualización de mis gastos e ingresos, ¡ahora tengo
                        control total!"</p>
                    <p class="mt-4 text-gray-500">- María González</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Llamado a la Acción -->
    <section class="py-16 bg-blue-600 text-white text-center">
        <h2 class="text-3xl font-semibold">¡Es hora de tomar el control!</h2>
        <p class="mt-4 text-lg">Únete ahora y empieza a gestionar tus finanzas de manera más eficiente y eficaz.</p>
        <a href="{{ route('login') }}"
            class="mt-6 inline-block px-8 py-4 bg-blue-800 text-white font-semibold rounded-lg hover:bg-blue-900 transform transition duration-300 hover:scale-105">
            Comienza Ahora
        </a>
    </section>
@endsection
