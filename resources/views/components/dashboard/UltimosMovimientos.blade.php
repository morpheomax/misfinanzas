<div class="bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Últimos Movimientos</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Últimos ingresos -->
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
            <h4 class="text-xl font-semibold text-green-600 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM16 12H8m8 0a4 4 0 00-8 0m8 0H8m0 4h8m-8 0a4 4 0 008 0m0 0v6" />
                </svg>
                Últimos Ingresos
            </h4>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-green-100 text-green-800">
                        <tr>
                            <th class="py-3 px-4 text-left font-semibold">Descripción</th>
                            <th class="py-3 px-4 text-left font-semibold">Monto</th>
                            <th class="py-3 px-4 text-left font-semibold">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-green-200">
                        @foreach ($ultimosIngresos as $ingreso)
                            <tr>
                                <td class="py-3 px-4">{{ $ingreso->nombre }}</td>
                                <td class="py-3 px-4">${{ number_format($ingreso->monto, 0, '', '.') }}</td>
                                <td class="py-3 px-4">{{ $ingreso->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Últimos egresos -->
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
            <h4 class="text-xl font-semibold text-red-600 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM8 12h8m0 0H8m8 0a4 4 0 00-8 0m0 0H8m8 4h-8m0 0a4 4 0 008 0m0 0v6" />
                </svg>
                Últimos Egresos
            </h4>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-red-100 text-red-800">
                        <tr>
                            <th class="py-3 px-4 text-left font-semibold">Descripción</th>
                            <th class="py-3 px-4 text-left font-semibold">Monto</th>
                            <th class="py-3 px-4 text-left font-semibold">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-red-200">
                        @foreach ($ultimosEgresos as $egreso)
                            <tr>
                                <td class="py-3 px-4">{{ $egreso->nombre }}</td>
                                <td class="py-3 px-4">${{ number_format($egreso->monto, 0, '', '.') }}</td>
                                <td class="py-3 px-4">{{ $egreso->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
