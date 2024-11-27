@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 ">

        {{-- RESUMEN INGRESOS --}}
        <h2 class="text-2xl font-semibold my-6 text-gray-800 text-center">Resumen de Ingresos</h2>


        <div class="flex flex-col md:flex-row gap-4 mx-auto">
            <!-- Mostrar acumulado anual -->
            @component('components.acumulado_anual', ['acumuladoAnual' => $acumuladoAnual])
            @endcomponent

            <!-- Mostrar acumulado anual Categoria-->
            @component('components.acumulado_anual_categoria', ['acumuladoAnualCategoria' => $acumuladoAnualCategoria])
                ||
            @endcomponent

            @component('components.ingresos_por_categoria_mes', [
                'datosAgrupados' => $ingresosAgrupados['datosAgrupados'],
                'totalesPorCategoria' => $ingresosAgrupados['totalesPorCategoria'],
                'meses' => $ingresosAgrupados['meses'],
                'anio' => $ingresosAgrupados['anio'],
                'aniosDisponibles' => $ingresosAgrupados['aniosDisponibles'],
            ])
            @endcomponent
        </div>



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
                    @include('components.form-ingreso') <!-- Aquí asumo que el gráfico tiene su propio componente -->
                </div>
            </section>


            <div class="w-full mx-auto">
                <!-- Componente del formulario -->
                @include('components.create-income-form')


                <!-- Componente de la tabla -->
                @include('components.income-table', ['ingresos' => $ingresos])
            </div>

            <div class="w-full mx-auto">
                @component('components.ingresos_por_categoria_mes', [
                    'datosAgrupados' => $ingresosAgrupados['datosAgrupados'],
                    'totalesPorCategoria' => $ingresosAgrupados['totalesPorCategoria'],
                    'meses' => $ingresosAgrupados['meses'],
                    'anio' => $ingresosAgrupados['anio'],
                    'aniosDisponibles' => $ingresosAgrupados['aniosDisponibles'],
                ])
                @endcomponent
            </div>
        </div>
    @endsection
