@extends('layouts.app')

@section('title', 'Registro de Ingresos')

@section('content')
    <div class="container mx-auto p-6">



        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        {{-- Sección: Formulario y Gráfico --}}
        <section class="flex flex-col lg:flex-row gap-6 mb-6 ">
            <!-- Formulario -->
            <div class="w-full   ">
                {{-- <h2 class="text-xl font-semibold mb-4 text-gray-800">Registrar un nuevo ingreso</h2> --}}
                <div class="h-full">
                    @include('components.ingresos.form-ingreso')
                </div>
            </div>

            <!-- Gráfico -->
            <div class="w-full">
                {{-- <h2 class="text-xl font-semibold mb-4 text-gray-800">Gráfico de Ingresos Mensual</h2> --}}
                @include('components.ingresos.grafico_ingreso_mensual', [
                    'totalesMensuales' => $totalesMensuales,
                ])
            </div>

        </section>


        {{-- Sección: Filtro y Tabla --}}
        <section class="w-full mx-auto mb-6">
            <!-- Filtrado de información -->
            @include('components.ingresos.create-income-form')

            <!-- Tabla de ingresos -->
            @include('components.ingresos.income-table', ['ingresos' => $ingresos])
        </section>

        {{-- Sección: Resumen de Ingresos --}}
        <section class="my-6 ">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800 text-center">Resumen de Ingresos</h2>

            <!-- Selector de Año -->
            <div class="text-center mb-4">
                @include('components.ingresos.select-year', [
                    'aniosDisponibles' => $aniosDisponibles,
                    'anioSeleccionado' => $anio,
                ])
            </div>
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Resumen de Ingresos por Categoría y Acumulado Anual -->
                <div class="w-full md:1/2 flex-grow">

                    <!-- Acumulado Anual -->
                    @include('components.ingresos.acumulado_anual', [
                        'acumuladoAnual' => $acumuladoAnual,
                        'anio' => $anio,
                        'aniosDisponibles' => $aniosDisponibles,
                    ])
                </div>


                <div class="w-full md:1/2 flex-grow">
                    <!-- Mostrar acumulado anual por categoría -->
                    @include('components.ingresos.acumulado_anual_categoria', [
                        'acumuladoAnualCategoria' => $acumuladoAnualCategoria,
                        'anio' => $anio,
                        'aniosDisponibles' => $aniosDisponibles,
                    ])
                </div>
            </div>
            <div class="w-full mt-6 ">
                <!-- Ingresos por Categoría y Mes -->
                @include('components.ingresos.ingresos_por_categoria_mes', [
                    'datosAgrupados' => $ingresosPorMesYCategoria,
                    'totalesPorCategoria' => $totalesPorCategoria,
                    'meses' => $meses,
                    'anio' => $anio,
                    'aniosDisponibles' => $aniosDisponibles,
                ])
            </div>



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
