<div class="my-6 ">
    <h3 class="text-2xl font-semibold text-gray-800 text-center">Filtrar Metas</h3>
    <form action="{{ route('metas.index') }}" method="GET" class="flex flex-wrap gap-4  items-center ">
        <div>
            <label for="desde" class="block text-sm font-medium text-gray-700">Desde</label>
            <input type="date" name="desde" id="desde" value="{{ request('desde') }}"
                class="mt-1 block w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 ">
        </div>
        <div>
            <label for="hasta" class="block text-sm font-medium text-gray-700">Hasta</label>
            <input type="date" name="hasta" id="hasta" value="{{ request('hasta') }}"
                class="mt-1 block w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500">
        </div>
        <div class="flex-grow">
            <label for="buscar" class="block text-sm font-medium text-gray-700">Buscar</label>
            <input type="text" name="buscar" id="buscar" value="{{ request('buscar') }}"
                placeholder="Buscar metas..."
                class="mt-1 block w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500">
        </div>
        <div class="self-end">
            <button type="submit"
                class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-200">
                Filtrar
            </button>
        </div>
    </form>
</div>
