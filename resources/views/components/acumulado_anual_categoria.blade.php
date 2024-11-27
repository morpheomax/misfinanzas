<div class="shadow-sm  rounded-2xl mb-4 p-4 bg-white text-negro ">

    <h3 class="text-md text-left font-semibold mb-4">Acumulado Anual</h3>

    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-gray-50 text-sm">
            <thead class="  ">
                <tr class="border-gray-50 text-center">
                    <th class="px-4 py-2 border-b border-gray-50  ">Año</th>
                    <th class="px-4 py-2 border-b border-gray-50 ">Categoría</th>

                    <th class="px-4 py-2 border-b border-gray-50 ">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($acumuladoAnualCategoria as $ingreso)
                    <tr class="hover:bg-gray-50 border-gray-50 ">
                        <td class="px-4 py-2 border-r border-gray-50">{{ $ingreso->anio }}</td>
                        <td class="px-4 py-2 border-b ">{{ $ingreso->categoria }}</td>
                        <td class="px-4 py-2  text-xl text-right font-bold">
                            ${{ number_format($ingreso->total_monto, 0, '', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $acumuladoAnualCategoria->links() }} <!-- Muestra los enlaces de paginación -->
    </div>
</div>
