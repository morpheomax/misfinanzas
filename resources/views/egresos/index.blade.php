@extends('layouts.app')

@section('title', 'Registro de Egresos')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-6 text-gray-800">Registro de Egresos</h1>
        @foreach ($egresos as $egreso)
            <p>{{ $egreso->descripcion }}</p>
        @endforeach
    </div>
@endsection
