{{-- @php
    $navItems = [
        ['url' => '/', 'label' => 'Inicio'],
        ['url' => '/ingresos', 'label' => 'Ingresos', 'auth' => true],
        ['url' => '/egresos', 'label' => 'Egresos', 'auth' => true],
        ['url' => '/metas', 'label' => 'Metas', 'auth' => true],
        ['url' => '/dashboard', 'label' => 'Dashboard', 'auth' => true],

        [
            'url' => route('login'),
            'label' => 'Ingresar',
            'auth' => false,
            'class' => 'bg-blue-500 text-white hover:bg-blue-600',
        ],
        [
            'url' => route('register'),
            'label' => 'Registrarse',
            'auth' => false,
            'class' => 'bg-green-500 text-white hover:bg-green-600',
        ],
    ];
@endphp

<nav class="bg-white dark:bg-gray-800 shadow-md">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Finanzas
        </a>

        <!-- Mobile menu button -->
        <button class="block lg:hidden text-gray-800 dark:text-gray-200 focus:outline-none" id="mobile-menu-button">
            <span class="sr-only">Toggle Menu</span>
            <!-- Menu icon (hamburger) -->
            <svg class="w-6 h-6 transition-all duration-300" id="menu-icon" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path id="line-1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16"></path>
                <path id="line-2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12h16">
                </path>
                <path id="line-3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 18h16">
                </path>
            </svg>
            <!-- Close icon (X) -->
            <svg class="w-6 h-6 transition-all duration-300 hidden" id="close-icon" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Navigation links -->
        <div class="hidden lg:flex items-center space-x-6" id="navbar-links">
            @foreach ($navItems as $item)
                @php
                    $isActive = request()->is(ltrim($item['url'], '/'));
                @endphp
                @if (isset($item['auth']) && $item['auth'] === true && Auth::check())
                    <a href="{{ $item['url'] }}"
                        class="text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white
                               {{ $isActive ? 'border-b-2 border-blue-500' : '' }}
                               transition-all duration-300 px-2 py-1 rounded-md">
                        {{ $item['label'] }}
                    </a>
                @elseif (isset($item['auth']) && $item['auth'] === false && !Auth::check())
                    <a href="{{ $item['url'] }}"
                        class="text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white
                               {{ $isActive ? 'border-b-2 border-blue-500' : '' }}
                               transition-all duration-300 px-2 py-1 rounded-md {{ $item['class'] ?? '' }}">
                        {{ $item['label'] }}
                    </a>
                @endif
            @endforeach
            @auth
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="text-gray-900 hover:text-gray-300 dark:text-gray-300 dark:hover:text-white
                               transition-all duration-300 px-4 py-1 rounded-md bg-slate-300 hover:bg-pink-700 ">
                        Cerrar
                    </button>
                </form>
            @endauth
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="lg:hidden bg-gray-100 dark:bg-gray-800 transition-all duration-300 transform ease-in-out overflow-hidden max-h-0"
        id="mobile-menu">
        <div class="flex flex-col items-center space-y-4 py-4 px-6">
            @foreach ($navItems as $item)
                @php
                    $isMobileActive = request()->is(ltrim($item['url'], '/'));
                @endphp
                @if (isset($item['auth']) && $item['auth'] === true && Auth::check())
                    <a href="{{ $item['url'] }}"
                        class="text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white w-full text-center
                               {{ $isMobileActive ? 'bg-blue-500 text-white' : '' }}
                               px-2 py-1 rounded-md">
                        {{ $item['label'] }}
                    </a>
                @elseif (isset($item['auth']) && $item['auth'] === false && !Auth::check())
                    <a href="{{ $item['url'] }}"
                        class="text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white w-full text-center
                               {{ $isMobileActive ? 'bg-blue-500 text-white' : '' }}
                               px-2 py-1 rounded-md {{ $item['class'] ?? '' }}">
                        {{ $item['label'] }}
                    </a>
                @endif
            @endforeach
            @auth
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="text-gray-900 hover:text-gray-300 dark:text-gray-300 dark:hover:text-white
                    transition-all duration-300 px-4 py-1 rounded-md bg-slate-300 hover:bg-pink-700 ">
                        Cerrar
                    </button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<script>
    // Toggle mobile menu
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');

        // Toggle menu visibility
        mobileMenu.classList.toggle('max-h-0');
        mobileMenu.classList.toggle('max-h-screen');

        // Toggle icon visibility
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');

        // Prevent page scroll when menu is open
        document.body.classList.toggle('overflow-hidden', mobileMenu.classList.contains('max-h-screen'));
    });

    // Close the mobile menu when clicking on a link
    document.querySelectorAll('#mobile-menu a').forEach(link => {
        link.addEventListener('click', () => {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');

            mobileMenu.classList.remove('max-h-screen');
            mobileMenu.classList.add('max-h-0');

            // Reset icons
            menuIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');

            document.body.classList.remove('overflow-hidden');
        });
    });
</script>

<style>
    /* Smooth transition for the mobile menu */
    #mobile-menu {
        transition: max-height 0.3s ease-in-out;
    }
</style> --}}



@php
    $navItems = [
        ['url' => '/', 'label' => 'Inicio'],
        ['url' => '/ingresos', 'label' => 'Ingresos', 'auth' => true],
        ['url' => '/egresos', 'label' => 'Egresos', 'auth' => true],
        ['url' => '/metas', 'label' => 'Metas', 'auth' => true],
        ['url' => '/dashboard', 'label' => 'Dashboard', 'auth' => true],
        [
            'url' => route('login'),
            'label' => 'Ingresar',
            'auth' => false,
            'class' => 'bg-blue-500 text-white hover:bg-blue-600',
        ],
        [
            'url' => route('register'),
            'label' => 'Registrarse',
            'auth' => false,
            'class' => 'bg-green-500 text-white hover:bg-green-600',
        ],
    ];
@endphp

<nav class="bg-white dark:bg-gray-800 shadow-md">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Finanzas
        </a>

        <!-- Navigation links -->
        <div class="hidden lg:flex items-center space-x-6">
            @foreach ($navItems as $item)
                @php
                    $isActive = request()->is(ltrim($item['url'], '/'));
                @endphp
                @if (isset($item['auth']) && $item['auth'] === true && Auth::check())
                    <a href="{{ $item['url'] }}"
                        class="text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white
                               {{ $isActive ? 'border-b-2 border-blue-500' : '' }}
                               transition-all duration-300 px-2 py-1 rounded-md">
                        {{ $item['label'] }}
                    </a>
                @elseif (isset($item['auth']) && $item['auth'] === false && !Auth::check())
                    <a href="{{ $item['url'] }}"
                        class="text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white
                               {{ $isActive ? 'border-b-2 border-blue-500' : '' }}
                               transition-all duration-300 px-2 py-1 rounded-md {{ $item['class'] ?? '' }}">
                        {{ $item['label'] }}
                    </a>
                @endif
            @endforeach

            @auth
                <!-- Dropdown Menu -->
                <div class="relative">
                    <button id="dropdownButton"
                        class="flex items-center space-x-2 text-gray-800 dark:text-gray-200 focus:outline-none">
                        <span>¡Hola, {{ Auth::user()->name }}!</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="dropdownMenu"
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg overflow-hidden hidden transition-all duration-300">
                        <a href="{{ route('user.show', ['user' => Auth::id()]) }}"
                            class="block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                            Ver Perfil
                        </a>
                        <a href="{{ route('user.edit', ['user' => Auth::id()]) }}"
                            class="block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                            Editar Perfil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>

        <!-- Mobile menu button -->
        <button class="block lg:hidden text-gray-800 dark:text-gray-200 focus:outline-none" id="mobile-menu-button">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div class="lg:hidden bg-gray-100 dark:bg-gray-800 transition-all duration-300 transform ease-in-out overflow-hidden max-h-0"
        id="mobile-menu">
        <div class="flex flex-col items-center space-y-4 py-4 px-6">
            @foreach ($navItems as $item)
                @if (isset($item['auth']) && $item['auth'] === true && Auth::check())
                    <a href="{{ $item['url'] }}"
                        class="text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white w-full text-center px-2 py-1 rounded-md">
                        {{ $item['label'] }}
                    </a>
                @elseif (isset($item['auth']) && $item['auth'] === false && !Auth::check())
                    <a href="{{ $item['url'] }}"
                        class="text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white w-full text-center px-2 py-1 rounded-md {{ $item['class'] ?? '' }}">
                        {{ $item['label'] }}
                    </a>
                @endif
            @endforeach

            @auth
                <!-- Mobile Dropdown -->
                <div class="relative">
                    <button id="mobileDropdownButton"
                        class="flex items-center justify-between w-full px-4 py-2 text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-gray-700 rounded-md">
                        Opciones
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="mobileDropdownMenu" class="hidden">
                        <a href="{{ route('user.show', ['user' => Auth::id()]) }}"
                            class="block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                            Ver Perfil
                        </a>
                        <a href="{{ route('user.edit', ['user' => Auth::id()]) }}"
                            class="block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                            Editar Perfil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>

<script>
    // Toggle mobile menu
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');

        // Toggle menu visibility
        mobileMenu.classList.toggle('max-h-0');
        mobileMenu.classList.toggle('max-h-screen');

        // Toggle icon visibility
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');

        // Prevent page scroll when menu is open
        document.body.classList.toggle('overflow-hidden', mobileMenu.classList.contains('max-h-screen'));
    });

    // Toggle dropdown for large screens
    const dropdownButton = document.getElementById('dropdownButton');
    const dropdownMenu = document.getElementById('dropdownMenu');
    dropdownButton.addEventListener('click', () => {
        dropdownMenu.classList.toggle('hidden');
    });

    // Toggle dropdown for mobile
    const mobileDropdownButton = document.getElementById('mobileDropdownButton');
    const mobileDropdownMenu = document.getElementById('mobileDropdownMenu');
    mobileDropdownButton.addEventListener('click', () => {
        mobileDropdownMenu.classList.toggle('hidden');
    });

    // Close the mobile menu when clicking on a link
    document.querySelectorAll('#mobile-menu a').forEach(link => {
        link.addEventListener('click', () => {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');

            mobileMenu.classList.remove('max-h-screen');
            mobileMenu.classList.add('max-h-0');

            // Reset icons
            menuIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');

            document.body.classList.remove('overflow-hidden');
        });
    });
</script>

<style>
    /* Smooth transition for the mobile menu */
    #mobile-menu {
        transition: max-height 0.3s ease-in-out;
    }
</style>
