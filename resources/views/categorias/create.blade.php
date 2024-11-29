@extends('layouts.app')

@section('title', 'Creación de Categorías')

@section('content')
    <div class="container">
        <h1>Crear Categoría</h1>
        <form action="{{ route('categorias.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la Categoría</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <select name="tipo" id="tipo" class="form-select" required>
                    <option value="">Selecciona un tipo</option>
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo }}">{{ ucfirst($tipo) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
