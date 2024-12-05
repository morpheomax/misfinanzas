<script>
    const ctx = document.getElementById('graficoBarreras').getContext('2d');
    const graficoBarreras = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($meses) !!}, // Meses
            datasets: [{
                label: 'Metas Cumplidas',
                data: {!! json_encode($totales) !!}, // Totales de metas cumplidas por mes
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
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
