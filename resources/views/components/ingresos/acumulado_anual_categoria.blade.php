@props(['acumuladoAnualCategoria', 'anio', 'aniosDisponibles'])

<div class="shadow-sm rounded-2xl mb-4 p-4 bg-white text-negro h-full">
    <h3 class="text-md text-left font-semibold mb-4">Acumulado Anual por Categoría ({{ $anio }})</h3>

    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-gray-50 text-sm">
            <thead>
                <tr class="border-gray-50 text-center font-bold">
                    <th class="px-4 py-2 border-b border-gray-50  ">Año</th>
                    <th class="px-4 py-2 border-b border-gray-50">Categoría</th>
                    <th class="px-4 py-2 border-b border-gray-50">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($acumuladoAnualCategoria as $ingreso)
                    <tr class="hover:bg-gray-50 border-gray-50 text-center font-bold text-lg">
                        <td class="px-4 py-2  " aria-label="Año de ingreso">
                            {{ $ingreso->year }}</td>
                        <td class="px-4 py-2  "aria-label="Categoría de ingreso">
                            {{ $ingreso->categoria }}</td>
                        <td class="px-4 py-2   " aria-label="Monto total">
                            ${{ number_format($ingreso->total_monto, 0, '', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center py-4 text-gray-500">No hay datos disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    {{-- @if ($acumuladoAnualCategoria instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-4">
            <div class="flex justify-center">
                {{ $acumuladoAnualCategoria->links() }}
            </div>
        </div>
    @endif --}}
</div>
