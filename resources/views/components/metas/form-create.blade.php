<form action="{{ route('metas.store') }}" method="POST" class="bg-white p-6 rounded-2xl shadow-md w-full ">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">Registrar Metas</h2>
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


        <!-- Estado -->
        <div class="mb-4">
            <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
            {{-- <input type="text" name="estado" id="estado"
                class="mt-2 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                required> --}}

            <select name="estado" id="estado"
                class="form-control mt-2 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                <option value="pendiente" {{ old('estado', $meta->estado ?? '') === 'pendiente' ? 'selected' : '' }}>
                    Pendiente</option>
                <option value="cumplida" {{ old('estado', $meta->estado ?? '') === 'cumplida' ? 'selected' : '' }}>
                    Cumplida</option>
            </select>
            @error('estado')
                <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Nombre -->
        <div class="mb-4">
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" name="nombre" id="nombre"
                class="mt-2 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                required>
            @error('nombre')
                <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
            @enderror
        </div>



        <!-- Monto -->
        <div class="mb-4">
            <label for="monto" class="block text-sm font-medium text-gray-700">Monto</label>
            <input type="number" name="monto" id="monto"
                class="mt-2 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                required>
            @error('monto')
                <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Monto Ahorrado-->
        <div class="mb-4">
            <label for="monto_ahorrado" class="block text-sm font-medium text-gray-700">Monto Ahorrado</label>
            <input type="number" name="monto_ahorrado" id="monto_ahorrado"
                class="mt-2 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                required>
            @error('monto_ahorrado')
                <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Fecha -->
        <div class="mb-4">
            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha de Cumplimiento</label>
            <input type="date" name="fecha" id="fecha"
                class="mt-2 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                required>
            @error('fecha')
                <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
            @enderror
        </div>

    </div>
    <div class="flex justify-center mt-6">
        <button type="submit"
            class="w-full mx-auto  bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-md transition duration-300 ease-in-out">
            Registrar
        </button>
    </div>
</form>

<script>
    // Este código captura los datos del formulario antes de enviarlo
    document.querySelector('form').addEventListener('submit', function(event) {
        const estado = document.getElementById('estado').value;
        const nombre = document.getElementById('nombre').value;
        const monto = document.getElementById('monto').value;
        const monto_ahorrado = document.getElementById('monto_ahorrado').value;
        const fecha = document.getElementById('fecha').value;

        // Muestra los datos en la consola para depuración
        console.log('Formulario enviado con los siguientes datos:', {
            estado,
            nombre,
            monto,
            monto_ahorrado,
            fecha
        });


    });
</script>
