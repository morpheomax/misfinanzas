@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 ">



        <div class="container mx-auto p-4">

            <section class="flex flex-col md:flex-row justify-between items-start gap-6 mb-6">
                <!-- Sección del formulario -->
                <div class="w-full md:w-1/2">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">Registrar un nuevo ingreso</h2>
                    @include('components.form-ingreso') <!-- Importa el componente del formulario -->
                </div>

                <!-- Sección del gráfico -->
                <div class="w-full md:w-1/2">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">Gráfico de Tortas</h2>

                    @include('components.grafico-torta', ['ingresosPorCategoria' => $ingresosPorCategoria])


                </div>
            </section>
            <div class="w-full mx-auto">
                <!-- Componente del formulario -->
                @include('components.create-income-form')

                <!-- Componente de la tabla -->
                @include('components.income-table', ['ingresos' => $ingresos])
            </div>



        </div>

        {{-- RESUMEN INGRESOS --}}
        <h2 class="text-2xl font-semibold my-6 text-gray-800 text-center">Resumen de Ingresos</h2>

        <div> {{-- selector de año --}}
            @include('components.select-year', [
                'aniosDisponibles' => $aniosDisponibles,
                'anioSeleccionado' => $anio,
            ])</div>
        <div class="flex flex-col md:flex-row gap-4 mx-auto">



            <div class="w-full mx-auto">
                @include('components.ingresos_por_categoria_mes', [
                    'datosAgrupados' => $ingresosPorMesYCategoria,
                    'totalesPorCategoria' => $totalesPorCategoria,
                    'meses' => $meses,
                    'anio' => $anio,
                    'aniosDisponibles' => $aniosDisponibles,
                ])

                <!-- Mostrar acumulado anual -->
                @include('components.acumulado_anual', [
                    'acumuladoAnual' => $acumuladoAnual,
                    'anio' => $anio,
                    'aniosDisponibles' => $aniosDisponibles,
                ])


                <!-- Mostrar acumulado anual por categoría -->
                @include('components.acumulado_anual_categoria', [
                    'acumuladoAnualCategoria' => $acumuladoAnualCategoria,
                    'anio' => $anio,
                    'aniosDisponibles' => $aniosDisponibles,
                ])

            </div>

        </div>

        <script>
            // Usamos AJAX para enviar el formulario sin recargar la página
            document.getElementById('anio').addEventListener('change', function() {
                const anioSeleccionado = this.value;

                // Hacer la solicitud AJAX al controlador
                fetch("{{ route('ingresos.index') }}?anio=" + anioSeleccionado, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Actualizar los componentes de acumulado anual y por categoría
                        document.getElementById('acumuladoAnual').innerHTML = data.acumuladoAnual;
                        document.getElementById('acumuladoAnualCategoria').innerHTML = data.acumuladoAnualCategoria;
                    })
                    .catch(error => console.error('Error:', error));
            });
        </script>
    @endsection
