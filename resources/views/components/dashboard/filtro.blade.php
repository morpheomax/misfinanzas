<div class="bg-white p-4 rounded-lg shadow-md">
    <h3 class="text-xl font-semibold text-gray-700 mb-4">Filtro por Ano y Mes</h3>

    <form action="{{ route('dashboard.index') }}" method="GET">
        <div class="grid grid-cols-1 sm:grid-cols-2  gap-4">
            <!-- Filtro de Año -->
            <div class="flex flex-col">
                <label for="anio" class="text-sm font-medium text-gray-600">Año</label>
                <select name="anio" id="anio" class="mt-2 p-2 border border-gray-300 rounded-lg"
                    value="{{ old('anio', $años[0] ?? '') }}">
                    <option value="">Seleccione un año</option>
                    @foreach ($años as $anio)
                        <option value="{{ $anio }}" {{ request('anio') == $anio ? 'selected' : '' }}>
                            {{ $anio }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro de Mes -->
            <div class="flex flex-col">
                <label for="mes" class="text-sm font-medium text-gray-600">Mes</label>
                <select name="mes" id="mes" class="mt-2 p-2 border border-gray-300 rounded-lg"
                    value="{{ old('mes', '') }}">
                    <option value="">Seleccione un mes</option>
                    @foreach ([
        '01' => 'Enero',
        '02' => 'Febrero',
        '03' => 'Marzo',
        '04' => 'Abril',
        '05' => 'Mayo',
        '06' => 'Junio',
        '07' => 'Julio',
        '08' => 'Agosto',
        '09' => 'Septiembre',
        '10' => 'Octubre',
        '11' => 'Noviembre',
        '12' => 'Diciembre',
    ] as $key => $month)
                        <option value="{{ $key }}" {{ request('mes') == $key ? 'selected' : '' }}>
                            {{ $month }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>
        <div class="mt-4">
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700">
                Aplicar Filtro
            </button>
        </div>
    </form>
</div>
