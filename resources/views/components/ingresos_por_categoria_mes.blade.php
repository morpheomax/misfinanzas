<div class="shadow-lg rounded-lg mb-4 p-4">
    <h3 class="text-lg font-semibold mb-4">Ingresos Agrupados por Año, Categoría y Mes</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-gray-50">
            <thead class="bg-indigo-600 text-white">
                <tr>
                    <th class="px-4 py-2 border-b text-left">Año</th>
                    <th class="px-4 py-2 border-b text-left">Categoría</th>
                    @for ($mes = 1; $mes <= 12; $mes++)
                        <th class="px-4 py-2 border-b text-left">Mes {{ $mes }}</th>
                    @endfor
                    <th class="px-4 py-2 border-b text-left">Total Monto</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ingresosAgrupados as $anio => $categorias)
                    @foreach ($categorias as $categoria => $meses)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b">{{ $anio }}</td>
                            <td class="px-4 py-2 border-b">{{ $categoria }}</td>
                            @php $total = 0; @endphp
                            @for ($mes = 1; $mes <= 12; $mes++)
                                <td class="px-4 py-2 border-b text-right">
                                    ${{ number_format($meses[$mes] ?? 0, 0, '', '.') }}
                                    @php $total += $meses[$mes] ?? 0; @endphp
                                </td>
                            @endfor
                            <td class="px-4 py-2 border-b text-right font-bold">
                                ${{ number_format($total, 0, '', '.') }}
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
