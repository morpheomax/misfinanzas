<div class="bg-white shadow-lg rounded-2xl p-6">
    <h3 class="text-xl font-semibold text-gray-700">Metas por Mes</h3>
    <!-- Contenedor responsivo -->
    <div class="overflow-x-auto">
        <table class="min-w-full mt-4 table-auto border-collapse">
            <thead>
                <tr>
                    @foreach ($metasPorMes as $mes => $total)
                        <th class="px-4 py-2 border text-center whitespace-nowrap">
                            {{ $mes }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach ($metasPorMes as $total)
                        <td class="px-4 py-2 border text-center">{{ $total }}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
</div>
