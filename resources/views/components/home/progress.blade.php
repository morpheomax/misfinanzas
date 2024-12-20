<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-semibold text-gray-700 dark:text-gray-300">Tu Progreso al Instante</h2>
        <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
            Visualiza tus resultados de manera clara con gráficos interactivos y análisis detallados.
        </p>
    </div>
    <div class="container mx-auto px-6 mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="w-full bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-4 min-h-[400px]">
            <canvas id="graficoProgreso1" class="w-full h-full"></canvas>
        </div>
        <div class="w-full bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-4 min-h-[400px] ">
            <canvas id="graficoProgreso2" class="w-full h-full "></canvas>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configuración del primer gráfico
        const ctx1 = document.getElementById('graficoProgreso1').getContext('2d');
        const graficoProgreso1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
                datasets: [{
                    label: 'Ingresos Mensuales',
                    data: [500000, 550000, 750000, 630000, 480000],
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Ingresos Mensuales',
                        font: {
                            size: 16,
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
                                return tooltipItem.raw + ' ingresos';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Meses'
                        }
                    }
                }
            }
        });

        // Configuración del segundo gráfico
        const ctx2 = document.getElementById('graficoProgreso2').getContext('2d');
        const graficoProgreso2 = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
                datasets: [{
                    label: 'Egresos Mensuales',
                    data: [300000, 150000, 680000, 380000, 414000],
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Egresos Mensuales',
                        font: {
                            size: 16,
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
                                return tooltipItem.raw + ' egresos';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Horas'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Meses'
                        }
                    }
                }
            }
        });

        // Ajustar los gráficos cuando se cambie el tamaño de la ventana
        window.addEventListener('resize', function() {
            graficoProgreso1.resize();
            graficoProgreso2.resize();
        });
    });
</script>

<style>
    canvas {
        display: block;
        width: 100%;
        height: 100%;
    }
</style>
