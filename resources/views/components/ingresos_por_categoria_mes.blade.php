<div class="container mx-auto p-4">
    <!-- Título de la Sección -->
    <h1 class="text-2xl font-semibold mb-6 text-center text-indigo-600">Resumen de Ingresos por Mes y Categoría
        ({{ $anio }})</h1>

    <!-- Filtro por Año -->
    <div class="mb-6 flex justify-center items-center space-x-4">
        <form method="GET" class="flex items-center space-x-2">
            <label for="anio" class="text-sm font-medium">Seleccionar Año:</label>
            <select name="anio" id="anio" class="form-select w-auto p-2 rounded-md border border-gray-300">
                @foreach ($aniosDisponibles as $opcionAnio)
                    <option value="{{ $opcionAnio }}" {{ $opcionAnio == $anio ? 'selected' : '' }}>
                        {{ $opcionAnio }}
                    </option>
                @endforeach
            </select>
            <button type="submit"
                class="btn btn-primary px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-300">Filtrar</button>
        </form>
    </div>

    <!-- Verificar si hay datos -->
    @if (count($datosAgrupados) > 0)

        <!-- Tabla de Datos -->
        <div class="overflow-x-auto shadow-lg rounded-lg mb-4">
            <table class="min-w-full border-collapse border border-gray-300">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">Categoría</th>
                        @foreach ($meses as $numero => $nombre)
                            <th class="px-4 py-2 text-left">{{ $nombre }}</th>
                        @endforeach
                        <th class="px-4 py-2 text-left">Total</th> <!-- Columna para el total -->
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
                                <!-- Mostrar el total -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <!-- Mensaje si no hay datos -->
        <div
            class="alert alert-warning text-center p-4 bg-yellow-100 border border-yellow-300 rounded-lg text-yellow-800">
            No se encontraron ingresos para el año seleccionado.
        </div>
    @endif
</div>
