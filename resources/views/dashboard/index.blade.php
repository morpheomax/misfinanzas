@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Dashboard</h1>
        <div class="flex flex-wrap gap-4">
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
        </div>

        {{-- Componentes --}}
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 py-6">



            @include('components.dashboard.filtro', [
                'años' => $años,
            ])
            @include('components.dashboard.ingresosTotales', [
                'ingresosTotales' => $ingresosTotales,
            ])
            @include('components.dashboard.egresosTotales')
            @include('components.dashboard.saldoGeneral')
        </div>
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-2  gap-6 py-6">
            @include('components.dashboard.resumenMensual', ['años' => $años])
            @include('components.dashboard.progresoMetas', ['años' => $años])
        </div>
        <div class="container mx-auto grid grid-cols-1 gap-6 py-6">
            @include('components.dashboard.categorias', ['años' => $años])
        </div>
        <div class="container mx-auto grid grid-cols-1 gap-6 py-6">
            @include('components.dashboard.ultimosMovimientos', ['años' => $años])
        </div>
    </div>
@endsection
