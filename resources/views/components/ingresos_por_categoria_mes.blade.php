@props(['datosAgrupados', 'totalesPorCategoria', 'meses', 'anio', 'aniosDisponibles'])

<div class="shadow-sm rounded-2xl mb-4 p-4 bg-white text-negro">
    <h3 class="text-md text-left font-semibold mb-4">Ingresos por Categoría y Mes ({{ $anio }})</h3>

    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-gray-50 text-sm">
            <thead>
                <tr class="border-gray-50 text-center">
                    <th class="px-4 py-2 border-b border-gray-50">Categoría</th>
                    @foreach ($meses as $numero => $nombre)
                        <th class="px-4 py-2 border-b border-gray-50">{{ $nombre }}</th>
                    @endforeach
                    <th class="px-4 py-2 border-b border-gray-50">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($totalesPorCategoria as $categoria => $total)
                    <tr class="hover:bg-gray-50 border-gray-50">
                        <td class="px-4 py-2 border-b">{{ $categoria }}</td>
                        @foreach ($meses as $numero => $nombre)
                            <td class="px-4 py-2 border-b text-right">
                                {{ isset($datosAgrupados[$categoria][$numero]) ? '$' . number_format($datosAgrupados[$categoria][$numero], 0, '', '.') : '$0' }}
                            </td>
                        @endforeach
                        <td class="px-4 py-2 border-b text-right font-bold">
                            ${{ number_format($total, 0, '', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($meses) + 2 }}" class="text-center py-4">No hay datos disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
