@php
    // Si no se ha pasado $totalesMensuales, inicializa un array vacío.
    $totalesMensuales = $totalesMensuales ?? [];
@endphp

@if (empty($totalesMensuales))
    <p class="text-gray-700">No hay datos disponibles para este mes.</p>
@else
    <table class="w-full border-collapse border border-gray-300 text-left">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2">Mes</th>
                <th class="border border-gray-300 px-4 py-2">Monto Total</th>
                <th class="border border-gray-300 px-4 py-2">Monto Ahorrado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($totalesMensuales as $mes => $data)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $mes }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ number_format($data['total'] ?? 0, 0, ',', '.') }}
                        <!-- Verifica si existe 'total', si no es 0 -->
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ number_format($data['ahorrado'] ?? 0, 0, ',', '.') }}
                        <!-- Verifica si existe 'ahorrado', si no es 0 -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
