<div class="bg-white shadow-lg rounded-lg p-6 mb-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Resumen Mensual</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-200 text-gray-700 uppercase text-sm">
                    <th class="p-3">Mes</th>
                    <th class="p-3">Ingresos</th>
                    <th class="p-3">Egresos</th>
                    <th class="p-3">Saldo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($resumenMensual as $resumen)
                    <tr class="border-b hover:bg-gray-100 transition">
                        <td class="p-3 text-gray-800 font-medium">{{ $resumen['mes'] }}</td>
                        <td class="p-3 text-green-600 font-semibold">
                            ${{ number_format($resumen['ingresos'], 0, '', '.') }}
                        </td>
                        <td class="p-3 text-red-600 font-semibold">
                            ${{ number_format($resumen['egresos'], 0, '', '.') }}
                        </td>
                        <td
                            class="p-3 font-semibold
                            {{ $resumen['saldo'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            ${{ number_format($resumen['saldo'], 0, '', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
