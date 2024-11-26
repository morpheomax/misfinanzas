@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">

        {{-- RESUMEN INGRESOS --}}

        <h2 class="text-2xl font-semibold my-6 text-gray-800 text-center ">Resumen de Ingresos</h2>

        <div class="flex flex-col md:flex-row gap-4 mx-auto">
            <!-- Mostrar acumulado anual -->
            @component('components.acumulado_anual', ['acumuladoAnual' => $acumuladoAnual])
            @endcomponent

            @component('components.ingresos_por_categoria_mes', [
                'datosAgrupados' => $ingresosAgrupados['datosAgrupados'],
                'totalesPorCategoria' => $ingresosAgrupados['totalesPorCategoria'], // No es necesario desreferenciar
                'meses' => $ingresosAgrupados['meses'],
                'anio' => $ingresosAgrupados['anio'],
                'aniosDisponibles' => $ingresosAgrupados['aniosDisponibles'],
            ])
            @endcomponent



        </div>

        {{-- <div class="flex flex-col md:flex-row gap-4 mx-auto">


            <!-- Mostrar ingresos por año, mes y categoría -->
            @component('components.ingresos_por_categoria_mes', ['ingresosAgrupados' => $ingresosAgrupados])
            @endcomponent
        </div> --}}

        {{-- Filtrado de datos de tabla --}}
        <div class="my-6">
            <h3 class="text-2xl font-semibold text-gray-800 text-center">Filtrar Ingresos</h3>
            <form action="{{ route('ingresos.index') }}" method="GET" class="flex flex-wrap gap-4">
                <!-- Filtro por fechas -->
                <div>
                    <label for="desde" class="block text-sm font-medium text-gray-700">Desde</label>
                    <input type="date" name="desde" id="desde" value="{{ request('desde') }}"
                        class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500">
                </div>
                <div>
                    <label for="hasta" class="block text-sm font-medium text-gray-700">Hasta</label>
                    <input type="date" name="hasta" id="hasta" value="{{ request('hasta') }}"
                        class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500">
                </div>

                <!-- Filtro por palabra clave -->
                <div class="flex-grow">
                    <label for="buscar" class="block text-sm font-medium text-gray-700">Buscar</label>
                    <input type="text" name="buscar" id="buscar" value="{{ request('buscar') }}"
                        placeholder="Buscar ingresos..."
                        class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500">
                </div>

                <!-- Botón para aplicar filtros -->
                <div class="self-end">
                    <button type="submit"
                        class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-200">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>


        <!-- Botón para agregar un nuevo ingreso -->
        <div class="flex justify-evenly items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800 my-6">Lista de Ingresos</h1>
            <a href="{{ route('ingresos.create') }}"
                class="bg-lime-500 text-white px-6 py-2 rounded-lg hover:bg-lime-600 transition duration-200">
                Agregar Ingreso
            </a>


        </div>



        <!-- Versión Móvil: Tarjetas -->
        <div class="md:hidden">
            @foreach ($ingresos as $ingreso)
                <div class="bg-white shadow-lg rounded-lg mb-4 p-4">
                    <h3 class="font-semibold text-lg text-gray-800">{{ $ingreso->nombre }}</h3>
                    <p class="text-gray-600">Categoría: {{ $ingreso->categoria }}</p>
                    <p class="text-gray-600">Monto: {{ '$' . number_format($ingreso->monto, 0, '', '.') }}</p>
                    <p class="text-gray-600">Fecha: {{ \Carbon\Carbon::parse($ingreso->fecha)->format('d/m/Y') }}</p>
                    <div class="mt-4 flex space-x-2">
                        <a href="{{ route('ingresos.show', $ingreso->id) }}" class="text-blue-500 hover:underline">Ver</a>
                        <a href="{{ route('ingresos.edit', $ingreso->id) }}"
                            class="text-yellow-500 hover:underline">Editar</a>
                        <form action="{{ route('ingresos.destroy', $ingreso->id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline"
                                onclick="return confirm('¿Estás seguro de eliminar este ingreso?')">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach

            <!-- Paginación móvil -->
            <div class="mt-4">
                {{ $ingresos->links() }}
            </div>
        </div>

        <!-- Versión Desktop: Tabla -->
        <div class="hidden md:block">
            <table class="min-w-full table-auto">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">#</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Nombre</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Categoría</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Monto</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Fecha</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    @foreach ($ingresos as $ingreso)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ $ingreso->nombre }}</td>
                            <td class="px-6 py-4">{{ $ingreso->categoria }}</td>
                            <td class="px-6 py-4">{{ '$' . number_format($ingreso->monto, 0, '', '.') }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($ingreso->fecha)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-4">
                                    <a href="{{ route('ingresos.show', $ingreso->id) }}"
                                        class="text-blue-500 hover:underline">Ver</a>
                                    <a href="{{ route('ingresos.edit', $ingreso->id) }}"
                                        class="text-yellow-500 hover:underline">Editar</a>
                                    <form action="{{ route('ingresos.destroy', $ingreso->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline"
                                            onclick="return confirm('¿Estás seguro de eliminar este ingreso?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Paginación de escritorio -->
            <div class="mt-4">
                {{ $ingresos->links() }}
            </div>
        </div>
    </div>
    {{-- Nuevos componentes --}}
    <div>








        <!-- Duplicar ingresos -->
        {{-- @component('components.duplicar_ingreso', ['ingreso' => $ingreso])
        @endcomponent --}}

    </div>
@endsection
