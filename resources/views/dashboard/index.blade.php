@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <main class="container mx-auto p-6">
        <header>
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Dashboard</h1>
        </header>

        <!-- Sección de enlaces -->
        <section class="flex flex-wrap gap-4 py-6">
            <a href="{{ route('ingresos.index') }}"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
                Ingresos
            </a>
            <a href="{{ route('egresos.index') }}"
                class="px-4 py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2">
                Egresos
            </a>
            <a href="{{ route('metas.index') }}"
                class="px-4 py-2 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2">
                Metas
            </a>
        </section>

        <!-- Sección de componentes -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 py-6">
            @include('components.dashboard.filtro', [
                'años' => $años,
            ])
            @include('components.dashboard.ingresosTotales', [
                'ingresosTotales' => $ingresosTotales,
            ])
            @include('components.dashboard.egresosTotales')
            @include('components.dashboard.saldoGeneral')
        </section>

        <!-- Sección de gráficos -->
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6 py-6">
            @include('components.dashboard.Grafico-acumulado', [
                'totalesMensuales' => $totalesMensuales,
                'anio' => $anio,
            ])
            @include('components.dashboard.Grafico-reumen', [
                'totalesMensuales' => $totalesMensuales,
                'anio' => $anio,
            ])
            @include('components.dashboard.Grafico-resumen-acumulado', [
                'totalesMensuales' => $totalesMensuales,
                'anio' => $anio,
            ])
        </section>

        <!-- Sección de resumen mensual y progreso de metas -->
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6 py-6">
            @include('components.dashboard.resumenMensual', ['años' => $años])
            @include('components.dashboard.progresoMetas', ['años' => $años])
        </section>

        <!-- Sección de categorías -->
        <section class="grid grid-cols-1 gap-6 py-6">
            @include('components.dashboard.categorias', ['años' => $años])
        </section>

        <!-- Sección de últimos movimientos -->
        <section class="grid grid-cols-1 gap-6 py-6">
            @include('components.dashboard.ultimosMovimientos', ['años' => $años])
        </section>
    </main>
@endsection
