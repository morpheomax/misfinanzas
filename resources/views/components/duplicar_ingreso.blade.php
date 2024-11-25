<div>
    <form method="POST" action="{{ route('ingresos.duplicate', $ingreso->id) }}">
        @csrf
        <button type="submit">Duplicar Ingreso</button>
    </form>
</div>
