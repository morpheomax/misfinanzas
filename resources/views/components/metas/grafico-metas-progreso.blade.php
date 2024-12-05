<div class="bg-white shadow-lg rounded-lg p-6">
    <h3 class="text-xl font-semibold text-gray-700">Progreso Acumulado de Metas</h3>
    <canvas id="graficoLineas" width="400" height="200"></canvas>
</div>

<script>
    const ctxLineas = document.getElementById('graficoLineas').getContext('2d');
    const graficoLineas = new Chart(ctxLineas, {
        type: 'line',
        data: {
            labels: {!! json_encode($metasCumplidasPorMes->pluck('mes')) !!}, // Meses
            datasets: [{
                label: 'Metas Cumplidas',
                data: {!! json_encode($metasCumplidasPorMes->pluck('total')) !!}, // Totales de metas cumplidas por mes
                fill: false,
                borderColor: 'rgba(75, 192, 192, 1)',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
