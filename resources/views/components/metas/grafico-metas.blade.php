<div class="w-full mx-auto bg-white shadow-lg rounded-2xl p-4 my-4 aspect-video ">

    <canvas id="graficoMetasPorMes" width="400" height="200" class="mt-6"></canvas>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const ctx = document.getElementById('graficoMetasPorMes').getContext('2d');
            const graficoMetasPorMes = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($metasPorMes->keys()->toArray()) !!}, // Etiquetas (meses)
                    datasets: [{
                        label: 'Metas por Mes',
                        data: {!! json_encode($metasPorMes->values()->toArray()) !!}, // Valores de metas
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        tension: 0.4,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Meses'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Total de Metas'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>

</div>
