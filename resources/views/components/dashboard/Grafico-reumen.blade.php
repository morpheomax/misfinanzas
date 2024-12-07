<div class="w-full mx-auto bg-white shadow-lg rounded-2xl p-4 min-h-[400px]">
    <canvas id="graficoMensual" class="w-full h-full"></canvas>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('graficoMensual').getContext('2d');
        const graficoMensual = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($totalesMensuales->pluck('mes')) !!},
                datasets: [{
                        label: 'Ingresos Mensuales',
                        data: {!! json_encode($totalesMensuales->pluck('ingresos')) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Egresos Mensuales',
                        data: {!! json_encode($totalesMensuales->pluck('egresos')) !!},
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Saldo Mensual',
                        data: {!! json_encode($totalesMensuales->pluck('saldo')) !!},
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        type: 'line',
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Resumen Mensual de Ingresos, Egresos y Saldo de {{ $anio }}',
                        font: {
                            size: 20,
                            weight: 'bold'
                        },
                        padding: {
                            top: 10,
                            bottom: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.raw.toLocaleString('es-CL');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Montos ($)'
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('es-CL');
                            }
                        }
                    },
                    x: {
                        stacked: true,
                        title: {
                            display: true,
                            text: 'Meses'
                        }
                    }
                }
            }
        });

        // Ajustar el gráfico cuando se cambie el tamaño de la ventana
        window.addEventListener('resize', function() {
            graficoSaldoAcumulativo.resize();
        });
    });
</script>
<style>
    #graficoSaldoAcumulativo {
        width: 100%;
        height: 100%;
    }
</style>
