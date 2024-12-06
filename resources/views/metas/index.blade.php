@extends('layouts.app')

@section('title', 'Registro de Metas')

@section('content')
    <div class="container mx-auto p-6">



        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        {{-- Sección: Formulario y Resultados --}}
        <section class="flex flex-col lg:flex-row gap-6 mb-6 ">
            <!-- Formulario -->
            <div class="w-full  md:w-1/2 ">

                {{-- <h2 class="text-xl font-semibold mb-4 text-gray-800">Registrar un nuevo ingreso</h2> --}}
                <div class="h-full">
                    @include('components.metas.form-create')
                    {{-- @include('components.ingresos.form-ingreso') --}}
                </div>
            </div>

            <!-- Resultados -->
            <div class="w-full md:w-1/2">

                <div class="w-full md:1/2 flex gap-4 flex-grow justify-center">

                    @include('components.metas.MetasCumplidas', ['metasCumplidas' => $metasCumplidas])
                    @include('components.metas.MetasPendientes', ['metasPendientes' => $metasPendientes])

                </div>
                @include('components.metas.grafico-metas', ['metasPorMes' => $metasPorMes])
            </div>

        </section>


        {{-- Sección: Filtro y Tabla --}}
        <section class="w-full mx-auto mb-6">
            <!-- Filtrado de información -->
            @include('components.metas.create-income-form')

            <!-- Tabla de metas -->
            @include('components.metas.income-table', ['metas' => $metas])
        </section>

        {{-- Sección: Resumen de Ingresos --}}
        <section class="my-6 ">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800 text-center">Resumen de Metas</h2>

            <!-- Selector de Año -->

            <div class="text-center mb-4">
                @include('components.metas.select-year', [
                    'aniosDisponibles' => $aniosDisponibles,
                    'anioSeleccionado' => $anio,
                ])
            </div>
            <div class="flex flex-col gap-4">



                <div class="w-full md:1/2 flex-grow">

                    @include('components.metas.MetasPorMes', ['metasPorMes' => $metasPorMes])


                </div>
            </div>
            <div class="w-full mt-6 ">

            </div>



        </section>



        {{-- Script: Actualización Dinámica con AJAX --}}
        <script>
            document.getElementById('anio').addEventListener('change', function() {
                const anioSeleccionado = this.value;

                fetch("{{ route('metas.index') }}?anio=" + anioSeleccionado, {
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
