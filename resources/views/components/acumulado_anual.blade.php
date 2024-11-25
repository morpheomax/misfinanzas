<div class=" shadow-lg rounded-lg mb-4 p-4  ">
    <h3 class="text-lg font-semibold mb-4">Acumulado Anual</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-gray-50">
            <thead class="bg-indigo-600 text-white ">
                <tr class="border-gray-50 ">
                    <th class="px-4 py-2 border-b border-gray-600 text-left">Año</th>
                    <th class="px-4 py-2 border-b border-gray-600 text-left">Total Monto</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($acumuladoAnual as $ingreso)
                    <tr class="hover:bg-gray-50 border-gray-50">
                        <td class="px-4 py-2 border-b ">{{ $ingreso->anio }}</td>
                        <td class="px-4 py-2 border-b ">
                            ${{ number_format($ingreso->total_monto, 0, '', '.') }}

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
