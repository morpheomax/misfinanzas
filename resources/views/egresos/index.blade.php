@extends('layouts.app')

@section('title', 'Registro de Egresos')

@section('content')
    <div class="container mx-auto p-6">



        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        {{-- Sección: Formulario y Gráfico --}}
        <section class="flex flex-col lg:flex-row gap-6 mb-6 ">
            <!-- Formulario -->
            <div class="w-full   ">

                <div class="h-full">
                    @include('components.egresos.form-egreso')
                </div>
            </div>

            <!-- Gráfico -->
            <div class="w-full">

                @include('components.egresos.grafico_egreso_mensual', [
                    'totalesMensuales' => $totalesMensuales,
                ])
            </div>

        </section>


        {{-- Sección: Filtro y Tabla --}}
        <section class="w-full mx-auto mb-6">
            <!-- Filtrado de información -->
            @include('components.egresos.create-income-form')

            <!-- Tabla de egresos -->
            @include('components.egresos.income-table', ['egresos' => $egresos])
        </section>

        {{-- Sección: Resumen de egresos --}}
        <section class="my-6 ">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800 text-center">Resumen de Egresos</h2>

            <!-- Selector de Año -->
            <div class="text-center mb-4">
                @include('components.egresos.select-year', [
                    'aniosDisponibles' => $aniosDisponibles,
                    'anioSeleccionado' => $anio,
                ])
            </div>
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Resumen de egresos por Categoría y Acumulado Anual -->
                <div class="w-full md:1/2 flex-grow">

                    <!-- Acumulado Anual -->
                    @include('components.egresos.acumulado_anual', [
                        'acumuladoAnual' => $acumuladoAnual,
                        'anio' => $anio,
                        'aniosDisponibles' => $aniosDisponibles,
                    ])
                </div>


                <div class="w-full md:1/2 flex-grow">
                    <!-- Mostrar acumulado anual por categoría -->
                    @include('components.egresos.acumulado_anual_categoria', [
                        'acumuladoAnualCategoria' => $acumuladoAnualCategoria,
                        'anio' => $anio,
                        'aniosDisponibles' => $aniosDisponibles,
                    ])
                </div>
            </div>
            <div class="w-full mt-6 ">
                <!-- Ingresos por Categoría y Mes -->
                @include('components.egresos.egresos_por_categoria_mes', [
                    'datosAgrupados' => $egresosPorMesYCategoria,
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

                fetch("{{ route('egresos.index') }}?anio=" + anioSeleccionado, {
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
