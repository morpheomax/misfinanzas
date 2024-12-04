<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Resumen Anual</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        @if ($summary->isEmpty())
            <p class="text-gray-700">No hay datos disponibles para este año.</p>
        @else
            <table class="w-full border-collapse border border-gray-300 text-left">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Año</th>
                        <th class="border border-gray-300 px-4 py-2">Monto Total</th>
                        <th class="border border-gray-300 px-4 py-2">Monto Ahorrado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($summary as $year => $data)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $year }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ number_format($data['total'], 0, ',', '.') }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ number_format($data['ahorrado'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
