@props(['acumuladoAnual', 'anio', 'aniosDisponibles'])

<div class="flex flex-col shadow-sm rounded-2xl mb-4 p-4 bg-white text-negro h-full">
    <h3 class="text-md text-left font-semibold mb-4">Acumulado Anual</h3>
    <div class="flex-grow ">
        <table class="min-w-full border-collapse border border-gray-50  font-bold">
            <thead>
                <tr class="border-gray-50 text-center">
                    <th class="px-4 py-2 border-b border-gray-50">Año</th>
                    <th class="px-4 py-2 border-b border-gray-50">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($acumuladoAnual as $egreso)
                    <tr class="hover:bg-gray-50 border-gray-50 text-lg text-center font-bold">
                        <td class="px-4 py-2 " aria-label="Año de egreso">
                            {{ $egreso['year'] }}</td>
                        <td class="px-4 py-2  " aria-label="Total acumulado">
                            ${{ number_format($egreso['total_monto'], 0, '', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    @if ($acumuladoAnual instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-4">
            <div class="flex justify-center">
                {{ $acumuladoAnual->links() }}
            </div>
        </div>
    @endif
</div>
