@extends('layouts.app')
@section('title', 'Información de tu cuenta')

@section('content')
    <div class="container">

        {{-- Solo usuarios administradores pueden ver esta información --}}
        @if (Auth::user()->role == 'admin')
            <h1>Información de tu cuenta</h1>
            <p><strong>Nombre:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Apellido:</strong> {{ Auth::user()->lastname }}</p>
            <p><strong>País:</strong> {{ Auth::user()->country }}</p>
            <p><strong>Ciudad:</strong> {{ Auth::user()->city }}</p>
        @endif

        {{-- Listar usuarios registrados --}}
        <h1>Información de Usuarios Registrados</h1>
        <p>Hay {{ $users->count() }} usuarios registrados.</p>
        @if ($users->count() > 0)
            <p>Los usuarios registrados son:</p>
        @endif
        @if ($users->isEmpty())
            <p>No hay usuarios registrados.</p>
        @endif

        <h2>Buscar Usuarios</h2>
        <form action="{{ route('user.index') }}" method="GET">
            <input type="text" name="search" placeholder="Buscar por nombre o email">
            <button type="submit">Buscar</button>
        </form>

        @if ($users->count() > 0)
            <p>Los usuarios registrados son:</p>
        @endif

        @if ($users->isEmpty())
            <p>No hay usuarios registrados.</p>
        @endif
        @if ($users->count() > 10)
            <p>Mostrando los primeros 10 resultados.</p>
        @endif



        <h2>Lista de Usuarios</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{ route('user.edit', $user) }}">Editar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
