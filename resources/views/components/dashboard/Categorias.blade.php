<div class="bg-white p-6 rounded-lg shadow-lg">
    <h3 class="text-2xl font-bold text-gray-800 mb-6">Ingresos y Egresos por Categoría</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Ingresos por Categoría -->
        <div>
            <h4 class="text-lg font-semibold text-green-600 mb-4 border-b border-green-200 pb-2">
                Ingresos por Categoría
            </h4>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-green-50">
                        <tr>
                            <th class="py-3 px-4 text-left text-sm font-medium text-green-700">
                                Categoría
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-green-700">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ingresosPorCategoria as $categoria)
                            <tr class="hover:bg-green-100 transition">
                                <td class="py-3 px-4 text-sm text-gray-800">
                                    {{ $categoria->categoria }}
                                </td>
                                <td class="py-3 px-4 text-sm text-gray-800">
                                    ${{ number_format($categoria->total, 0, '', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Egresos por Categoría -->
        <div>
            <h4 class="text-lg font-semibold text-red-600 mb-4 border-b border-red-200 pb-2">
                Egresos por Categoría
            </h4>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-red-50">
                        <tr>
                            <th class="py-3 px-4 text-left text-sm font-medium text-red-700">
                                Categoría
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-red-700">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($egresosPorCategoria as $categoria)
                            <tr class="hover:bg-red-100 transition">
                                <td class="py-3 px-4 text-sm text-gray-800">
                                    {{ $categoria->categoria }}
                                </td>
                                <td class="py-3 px-4 text-sm text-gray-800">
                                    ${{ number_format($categoria->total, 0, '', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
