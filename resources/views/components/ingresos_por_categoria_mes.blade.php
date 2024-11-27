<div class="container mx-auto p-4">
    <!-- Título de la Sección -->


    <!-- Filtro por Año -->
    <div class="mb-2 flex justify-center text-xs ">
        {{-- <h1 class="text-xl md:text-2xl font-semibold mb-6 text-center text-indigo-600">
            Mes y Categoría ({{ $anio }})
        </h1> --}}
        <form method="GET" class="flex items-center space-x-2 bg-white/60 backdrop-blur-lg rounded-lg p-4 shadow-lg">
            <label for="anio" class="text-sm font-medium text-gray-800">Seleccionar Año:</label>
            <select name="anio" id="anio"
                class="form-select w-auto p-2 rounded-md border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700">
                @foreach ($aniosDisponibles as $opcionAnio)
                    <option value="{{ $opcionAnio }}" {{ $opcionAnio == $anio ? 'selected' : '' }}>
                        {{ $opcionAnio }}
                    </option>
                @endforeach
            </select>
            <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-300">Filtrar</button>
        </form>
    </div>

    <!-- Verificar si hay datos -->
    @if (count($datosAgrupados) > 0)
        <!-- Tabla de Datos -->
        <div class="bg-white/60 backdrop-blur-lg shadow-lg rounded-lg mb-4 p-4 text-xs">
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-gray-300 rounded-lg">
                    <thead class="bg-indigo-600 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left">Categoría</th>
                            @foreach ($meses as $numero => $nombre)
                                <th class="px-4 py-2 text-left">{{ $nombre }}</th>
                            @endforeach
                            <th class="px-4 py-2 text-left">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datosAgrupados as $categoria => $mesesData)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border-b">{{ $categoria }}</td>
                                @foreach ($meses as $numero => $nombre)
                                    <td class="px-4 py-2 border-b text-right">
                                        @if (isset($mesesData[$numero]))
                                            ${{ number_format($mesesData[$numero], 0, '', '.') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endforeach
                                <td class="px-4 py-2 border-b text-right">
                                    ${{ number_format($totalesPorCategoria[$categoria], 0, '', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Mensaje si no hay datos -->
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 mb-4 rounded-lg shadow-lg">
            No se encontraron ingresos para el año seleccionado.
        </div>
    @endif
</div>
