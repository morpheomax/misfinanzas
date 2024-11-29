@extends('layouts.app')

@section('title', 'Edición de Categorías')

@section('content')
    <div class="container">
        <h1>Editar Categoría</h1>
        <form action="{{ route('categorias.update', $categoria) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la Categoría</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $categoria->nombre }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <select name="tipo" id="tipo" class="form-select" required>
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo }}" {{ $categoria->tipo == $tipo ? 'selected' : '' }}>
                            {{ ucfirst($tipo) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
