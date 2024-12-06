<div class="bg-white shadow-md rounded-lg p-4 mb-4">
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
</div>
