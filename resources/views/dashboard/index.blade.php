@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <main class="container mx-auto p-6 ">
        <header class="flex justify-around items-center mb-6 ">
            <h1 class="text-3xl font-semibold text-gray-200 dark:text-gray-700">Tus Resultados</h1>


        </header>



        <!-- Sección de componentes -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 py-6">
            @include('components.dashboard.filtro', [
                'años' => $años,
            ])
            @include('components.dashboard.IngresosTotales', [
                'ingresosTotales' => $ingresosTotales,
            ])
            @include('components.dashboard.EgresosTotales')
            @include('components.dashboard.SaldoGeneral')

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
            @include('components.dashboard.ProgresoMetas', ['años' => $años])

        </section>





        <!-- Sección de resumen mensual y progreso de metas -->
        <section class="grid grid-cols-1 gap-6 py-6">
            @include('components.dashboard.ResumenMensual', ['años' => $años])
        </section>

        <!-- Sección de categorías -->
        <section class="grid grid-cols-1 gap-6 py-6">
            @include('components.dashboard.Categorias', ['años' => $años])
        </section>

        <!-- Sección de últimos movimientos -->
        <section class="grid grid-cols-1 gap-6 py-6">
            @include('components.dashboard.UltimosMovimientos', ['años' => $años])
        </section>
    </main>
@endsection
