<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    {{-- Livewire  --}}
    @livewireStyles
</head>

<body class="flex flex-col min-h-screen bg-super-blanco">

    <!-- Navbar -->

    @include('components.navbar')


    <!-- Contenido Principal -->
    <main class="flex-1">
        {{-- Alertas de SweetAlert --}}
        @if (session('swal'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: "{{ session('swal')['title'] }}",
                            text: "{{ session('swal')['text'] }}",
                            icon: "{{ session('swal')['icon'] }}",
                            timer: 3000,
                            timerProgressBar: true, // Muestra barra de progreso
                            toast: true, // Aparece como un toast en lugar de una ventana modal
                            position: 'top-center', // Posición en la esquina superior derecha
                            showConfirmButton: false
                        });
                    }
                });
            </script>
        @endif

        {{-- Fin de alertas --}}

        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')

    {{-- Livewire --}}
    @livewireScripts
    <!-- Scripts Globales -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
