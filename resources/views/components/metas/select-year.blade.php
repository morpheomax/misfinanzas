@props(['aniosDisponibles', 'anioSeleccionado'])

<div class="mb-4 my-0">
    <form method="GET" action="{{ route('metas.index') }}">
        <label for="anio" class="font-semibold">Selecciona el Año:</label>
        <select name="anio" id="anio" class="form-select mt-2 p-2 border rounded-md" onchange="this.form.submit()">
            <option value="" disabled selected>Seleccione un año</option>
            @foreach ($aniosDisponibles as $anio)
                <option value="{{ $anio }}" @if ($anio == $anioSeleccionado) selected @endif>
                    {{ $anio }}
                </option>
            @endforeach
        </select>
    </form>
</div>
