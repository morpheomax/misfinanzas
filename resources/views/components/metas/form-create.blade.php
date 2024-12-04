<form action="{{ route('metas.store') }}" method="POST" class="bg-white p-6 rounded-2xl shadow-md w-full ">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">Registrar Metas</h2>
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

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
    // Llamada a la API para obtener los tipos con Egreso'
    fetch('/api/tipo/egreso/')
        .then(response => response.json())
        .then(tipos => {
            const tipoSelect = document.getElementById('tipo');
            tipos.forEach(tipo => {
                const option = document.createElement('option');
                option.value = tipo;
                option.textContent = tipo;
                tipoSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error al obtener los tipos:', error));

    // Llamada a la API para obtener los nombres según el tipo seleccionado
    document.getElementById('tipo').addEventListener('change', function() {
        const tipoSeleccionado = this.value;

        if (tipoSeleccionado) {
            // Si un tipo es seleccionado, hacemos la llamada para obtener los nombres
            fetch(`/api/tipo/${tipoSeleccionado}/nombre`)
                .then(response => response.json())
                .then(nombres => {
                    const nombreSelect = document.getElementById('nombre');
                    nombreSelect.innerHTML =
                        '<option value="">Seleccione un nombre</option>'; // Limpiar opciones previas

                    nombres.forEach(nombre => {
                        const option = document.createElement('option');
                        option.value = nombre.nombre;
                        option.textContent = nombre.nombre;
                        nombreSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al obtener los nombres:', error));
        } else {
            // Si no se ha seleccionado tipo, limpiar el selector de nombres
            document.getElementById('nombre').innerHTML = '<option value="">Seleccione un nombre</option>';
        }
    });

    // Este código captura los datos del formulario antes de enviarlo
    document.querySelector('form').addEventListener('submit', function(event) {
        const categoria = document.getElementById('tipo').value;
        const nombre = document.getElementById('nombre').value;
        const monto = document.getElementById('monto').value;
        const fecha = document.getElementById('fecha').value;

        // Muestra los datos en la consola para depuración
        console.log('Formulario enviado con los siguientes datos:', {
            categoria,
            nombre,
            monto,
            fecha
        });


    });
</script>
