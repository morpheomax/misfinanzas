<div class="bg-white p-4 rounded-lg shadow-md">
    <h3 class="text-xl font-semibold text-gray-700 mb-4">Últimos Movimientos </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Últimos ingresos -->
        <div>
            <h4 class="text-lg font-semibold text-green-600 mb-2">Últimos Ingresos</h4>
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="py-2 px-4 text-left text-sm font-medium text-gray-600">Descripción</th>
                        <th class="py-2 px-4 text-left text-sm font-medium text-gray-600">Monto</th>
                        <th class="py-2 px-4 text-left text-sm font-medium text-gray-600">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ultimosIngresos as $ingreso)
                        <tr>
                            <td class="py-2 px-4 text-sm text-gray-700">{{ $ingreso->nombre }}</td>
                            <td class="py-2 px-4 text-sm text-gray-700">${{ number_format($ingreso->monto, 0, '', '.') }}
                            </td>
                            <td class="py-2 px-4 text-sm text-gray-700">{{ $ingreso->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Últimos egresos -->
        <div>
            <h4 class="text-lg font-semibold text-red-600 mb-2">Últimos Egresos</h4>
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="py-2 px-4 text-left text-sm font-medium text-gray-600">Descripción</th>
                        <th class="py-2 px-4 text-left text-sm font-medium text-gray-600">Monto</th>
                        <th class="py-2 px-4 text-left text-sm font-medium text-gray-600">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ultimosEgresos as $egreso)
                        <tr>
                            <td class="py-2 px-4 text-sm text-gray-700">{{ $egreso->nombre }}</td>
                            <td class="py-2 px-4 text-sm text-gray-700">${{ number_format($egreso->monto, 0, '', '.') }}
                            </td>
                            <td class="py-2 px-4 text-sm text-gray-700">{{ $egreso->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
