<div class="bg-white shadow-lg rounded-2xl p-6 mb-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Progreso de Metas - Año {{ $anio }}</h2>

    <!-- Contenedor de metas (usando grid) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
        @foreach ($progresoMetas as $meta)
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-4">
                <div class="flex justify-between items-center mb-4">
                    <p class="text-xl font-semibold text-gray-800">{{ $meta['nombre'] }}</p>
                    <span class="text-sm text-gray-500">{{ round($meta['progreso']) }}%</span>
                </div>

                <!-- Barra de progreso -->
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="h-3 rounded-full"
                        style="width: {{ $meta['progreso'] }}%;
                                background-color: {{ $meta['progreso'] == 100 ? '#22c55e' : '#3b82f6' }};">
                    </div>
                </div>

                <!-- Progreso visual (monto ahorrado vs meta) -->
                <div class="flex justify-between mt-2 text-sm text-gray-600">
                    <span>Ahorro: <span
                            class="font-semibold text-gray-800">${{ number_format($meta['monto_ahorrado'] ?? 0, 0, ',', '.') }}</span></span>
                    <span>Meta: <span
                            class="font-semibold text-gray-800">${{ number_format($meta['monto'] ?? 0, 0, ',', '.') }}</span></span>
                </div>

                <!-- Estado de la meta -->
                <p class="text-sm text-gray-500 mt-2">
                    Estado: <span
                        class="font-medium text-sm text-{{ $meta['estado'] == 'cumplida' ? 'green' : 'yellow' }}-500">{{ ucfirst($meta['estado']) }}</span>
                </p>

                <!-- Información adicional -->
                @if ($meta['estado'] == 'cumplida')
                    <p class="text-sm text-gray-500 mt-1">Cumplida el: <span
                            class="font-medium text-green-500">{{ $meta['fecha_cumplimiento'] }}</span></p>
                @elseif ($meta['estado'] == 'pendiente')
                    <p class="text-sm text-gray-500 mt-1">Pendiente hasta: <span
                            class="font-medium text-yellow-500">{{ $meta['fecha_pendiente'] }}</span></p>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Paginación -->
    <div class="flex justify-center mt-6">
        {{ $progresoMetas->links() }}
    </div>
</div>
