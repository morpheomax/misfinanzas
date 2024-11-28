@extends('layouts.app')

@section('title', 'Registro de Ingresos')

@section('content')
    <div class="container mx-auto p-4">

        {{-- Sección: Formulario y Gráfico --}}
        <section class="flex flex-col md:flex-row justify-between items-stretch gap-6 mb-6">
            <!-- Formulario -->
            <div class="w-full md:w-1/2 flex flex-col justify-between ">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Registrar un nuevo ingreso</h2>
                <div class="h-full"> <!-- Envuelve el componente para que crezca si es necesario -->
                    @include('components.form-ingreso')
                </div>
            </div>

            <!-- Gráfico -->
            <div class="w-full md:w-1/2 flex flex-col justify-between ">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Gráfico de Ingresos Mensual</h2>
                <div class="h-full"> <!-- Asegura que también crezca para igualar la altura -->
                    @include('components.grafico_ingreso_mensual', [
                        'totalesMensuales' => $totalesMensuales,
                    ])
                </div>
            </div>
        </section>


        {{-- Sección: Formulario y Tabla --}}
        <section class="w-full mx-auto mb-6">
            <!-- Formulario para crear ingresos -->
            @include('components.create-income-form')

            <!-- Tabla de ingresos -->
            @include('components.income-table', ['ingresos' => $ingresos])
        </section>

        {{-- Sección: Resumen de Ingresos --}}
        <section class="my-6">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800 text-center">Resumen de Ingresos</h2>

            <!-- Selector de Año -->
            <div class="text-center mb-4">
                @include('components.select-year', [
                    'aniosDisponibles' => $aniosDisponibles,
                    'anioSeleccionado' => $anio,
                ])
            </div>

            <!-- Resumen de Ingresos por Categoría y Acumulado Anual -->
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Acumulado Anual -->
                @include('components.acumulado_anual', [
                    'acumuladoAnual' => $acumuladoAnual,
                    'anio' => $anio,
                    'aniosDisponibles' => $aniosDisponibles,
                ])

                <!-- Ingresos por Categoría y Mes -->
                @include('components.ingresos_por_categoria_mes', [
                    'datosAgrupados' => $ingresosPorMesYCategoria,
                    'totalesPorCategoria' => $totalesPorCategoria,
                    'meses' => $meses,
                    'anio' => $anio,
                    'aniosDisponibles' => $aniosDisponibles,
                ])
            </div>

            {{-- <!-- Mostrar acumulado anual por categoría -->
                @include('components.acumulado_anual_categoria', [
                    'acumuladoAnualCategoria' => $acumuladoAnualCategoria,
                    'anio' => $anio,
                    'aniosDisponibles' => $aniosDisponibles,
                ]) --}}
        </section>

        {{-- Script: Actualización Dinámica con AJAX --}}
        <script>
            document.getElementById('anio').addEventListener('change', function() {
                const anioSeleccionado = this.value;

                fetch("{{ route('ingresos.index') }}?anio=" + anioSeleccionado, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('acumuladoAnual').innerHTML = data.acumuladoAnual;
                        document.getElementById('acumuladoAnualCategoria').innerHTML = data.acumuladoAnualCategoria;
                    })
                    .catch(error => console.error('Error:', error));
            });
        </script>

    </div>
@endsection
