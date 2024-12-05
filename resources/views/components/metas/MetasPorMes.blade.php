<div class="bg-white shadow-lg rounded-lg p-6">
    <h3 class="text-xl font-semibold text-gray-700">Metas por Mes</h3>
    <table class="min-w-full mt-4 table-auto border-collapse">
        <thead>
            <tr>
                <th class="px-4 py-2 border text-left">Mes</th>
                <th class="px-4 py-2 border text-left">Total de Metas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($metasPorMes as $mes => $total)
                <tr>
                    <td class="px-4 py-2 border">{{ $mes }}</td>
                    <td class="px-4 py-2 border">{{ $total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
