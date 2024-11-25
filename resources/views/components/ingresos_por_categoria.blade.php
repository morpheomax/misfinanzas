<div class=" shadow-lg rounded-lg mb-4 p-4  ">
    <h3 class="text-lg font-semibold mb-4">Ingresos por Año, Mes y Categoría</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-gray-50">
            <thead class="bg-indigo-600 text-white ">
                <tr class="border-gray-50 ">
                    <th class="px-4 py-2 border-b  text-left">Año</th>
                    <th class="px-4 py-2 border-b  text-left">Mes</th>
                    <th class="px-4 py-2 border-b  text-left">Categoría</th>
                    <th class="px-4 py-2 border-b text-left">Total Monto</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ingresosPorMesYCategoria as $ingreso)
                    <tr class="hover:bg-gray-50 border-gray-50">
                        <td class="px-4 py-2 border-b ">{{ $ingreso->anio }}</td>
                        <td class="px-4 py-2 border-b ">{{ $ingreso->mes }}</td>
                        <td class="px-4 py-2 border-b ">{{ $ingreso->categoria }}</td>
                        <td class="px-4 py-2 border-b text-right">
                            ${{ number_format($ingreso->total_monto, 0, '', '.') }}

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
