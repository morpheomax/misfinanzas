<div class="bg-white shadow-md rounded-lg p-4 mb-4">
    <h2 class="text-lg font-semibold">Resumen Mensual</h2>
    <table class="w-full border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Mes</th>
                <th class="border p-2">Ingresos</th>
                <th class="border p-2">Egresos</th>
                <th class="border p-2">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resumenMensual as $resumen)
                <tr>
                    <td class="border p-2">{{ $resumen['mes'] }}</td>
                    <td class="border p-2">${{ number_format($resumen['ingresos'], 0, '', '.') }}</td>
                    <td class="border p-2">${{ number_format($resumen['egresos'], 0, '', '.') }}</td>
                    <td class="border p-2">${{ number_format($resumen['saldo'], 0, '', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{--
<div class="bg-white shadow-md rounded-lg p-4 mb-4">
    <h2 class="text-lg font-semibold">Resumen Mensual - Año: {{ $anio }} - Mes: {{ $mes }}</h2>

    <!-- Tabla de resumen mensual -->
    <table class="w-full border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Mes</th>
                <th class="border p-2">Ingresos</th>
                <th class="border p-2">Egresos</th>
                <th class="border p-2">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resumenMensual as $resumen)
                <tr>
                    <td class="border p-2">{{ $resumen['mes'] }}</td>
                    <td class="border p-2">${{ number_format($resumen['ingresos'], 0, '', '.') }}</td>
                    <td class="border p-2">${{ number_format($resumen['egresos'], 0, '', '.') }}</td>
                    <td class="border p-2">${{ number_format($resumen['saldo'], 0, '', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div> --}}
