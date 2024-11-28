@props(['ingresosPorCategoria'])

<div class="bg-white rounded-2xl shadow-md p-4">
    <h3 class="text-md font-semibold mb-4">Gráfico de Ingresos por Categoría</h3>
    <canvas id="graficoTorta"></canvas>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('graficoTorta').getContext('2d');
        const data = {
            labels: {!! json_encode($ingresosPorCategoria->pluck('categoria')) !!},
            datasets: [{
                label: 'Ingresos por Categoría',
                data: {!! json_encode($ingresosPorCategoria->pluck('total_monto')) !!},
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF',
                    '#FF9F40'
                ],
                hoverOffset: 4
            }]
        };
        const graficoTorta = new Chart(ctx, {
            type: 'pie',
            data: data,
        });
    </script>
@endpush
