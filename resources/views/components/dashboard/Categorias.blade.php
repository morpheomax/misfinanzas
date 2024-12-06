<div class="bg-white p-4 rounded-lg shadow-md">
    <h3 class="text-xl font-semibold text-gray-700 mb-4">Ingresos y Egresos por Categoría</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Ingresos por Categoría -->
        <div>
            <h4 class="text-lg font-semibold text-green-600 mb-2">Ingresos por Categoría</h4>
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="py-2 px-4 text-left text-sm font-medium text-gray-600">Categoría</th>
                        <th class="py-2 px-4 text-left text-sm font-medium text-gray-600">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ingresosPorCategoria as $categoria)
                        <tr>
                            <td class="py-2 px-4 text-sm text-gray-700">{{ $categoria->categoria }}</td>
                            <td class="py-2 px-4 text-sm text-gray-700">
                                ${{ number_format($categoria->total, 0, '', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Egresos por Categoría -->
        <div>
            <h4 class="text-lg font-semibold text-red-600 mb-2">Egresos por Categoría</h4>
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="py-2 px-4 text-left text-sm font-medium text-gray-600">Categoría</th>
                        <th class="py-2 px-4 text-left text-sm font-medium text-gray-600">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($egresosPorCategoria as $categoria)
                        <tr>
                            <td class="py-2 px-4 text-sm text-gray-700">{{ $categoria->categoria }}</td>
                            <td class="py-2 px-4 text-sm text-gray-700">
                                ${{ number_format($categoria->total, 0, '', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
