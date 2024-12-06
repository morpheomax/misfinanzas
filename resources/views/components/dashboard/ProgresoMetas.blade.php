{{-- <div class="bg-white shadow-md rounded-lg p-4 mb-4">
    <h2 class="text-lg font-semibold">Progreso de Metas</h2>
    @foreach ($progresoMetas as $meta)
        <div class="mb-2">
            <p><strong>{{ $meta['nombre'] }}</strong></p>
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="bg-green-500 h-4 rounded-full" style="width: {{ $meta['progreso'] }}%;">
                </div>
            </div>
            <p class="text-sm">Estado: {{ ucfirst($meta['estado']) }}</p>
        </div>
    @endforeach
</div> --}}

<div class="bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Progreso de Metas</h2>

    <!-- Filtro por estado -->
    <form method="GET" class="mb-4 flex gap-2">
        <select name="estado"
            class="border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Todas las metas</option>
            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="cumplida" {{ request('estado') == 'cumplida' ? 'selected' : '' }}>Cumplida</option>
        </select>
        <button type="submit" class="bg-blue-500 text-white rounded-md px-4 py-2 hover:bg-blue-600 transition">
            Filtrar
        </button>
    </form>

    <!-- Lista de metas -->
    @foreach ($progresoMetas as $meta)
        <div class="mb-4">
            <div class="flex justify-between items-center mb-2">
                <p class="text-lg font-semibold">{{ $meta['nombre'] }}</p>
                <span class="text-sm text-gray-600">{{ round($meta['progreso']) }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="h-4 rounded-full"
                    style="width: {{ $meta['progreso'] }}%;
                    background-color: {{ $meta['progreso'] == 100 ? '#22c55e' : '#3b82f6' }};">
                </div>
            </div>
            <p class="text-sm text-gray-500 mt-1">Estado: <span
                    class="font-medium">{{ ucfirst($meta['estado']) }}</span></p>
        </div>
    @endforeach


    {{ $progresoMetas->links() }}
</div>
