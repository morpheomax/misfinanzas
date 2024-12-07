<div class="w-full mx-auto bg-white shadow-lg rounded-2xl p-4 aspect-video">
    <canvas id="graficoSaldoAcumulativo"></canvas>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctxSaldoAcumulativo = document.getElementById('graficoSaldoAcumulativo').getContext('2d');

        // Calcular saldo acumulativo
        const saldoAcumulativo = {!! json_encode(
            $totalesMensuales->pluck('saldo')->reduce(function ($carry, $item) {
                return $carry->push(($carry->last() ?? 0) + $item);
            }, collect()),
        ) !!};

        // Crear el gráfico
        const graficoSaldoAcumulativo = new Chart(ctxSaldoAcumulativo, {
            type: 'line', // Tipo de gráfico de líneas
            data: {
                labels: {!! json_encode($totalesMensuales->pluck('mes')) !!}, // Meses
                datasets: [{
                        label: 'Ingresos Mensuales',
                        data: {!! json_encode($totalesMensuales->pluck('ingresos')) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color fondo
                        borderColor: 'rgba(54, 162, 235, 1)', // Color de la línea
                        borderWidth: 2
                    },
                    {
                        label: 'Egresos Mensuales',
                        data: {!! json_encode($totalesMensuales->pluck('egresos')) !!},
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2
                    },
                    {
                        label: 'Saldo Acumulativo',
                        data: saldoAcumulativo,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 3,
                        tension: 0.4 // Suaviza la curva
                    }
                ]
            },
            options: {
                responsive: true, // Hacer el gráfico responsivo
                maintainAspectRatio: false, // No mantener proporción fija
                plugins: {
                    title: {
                        display: true,
                        text: 'Saldo Acumulado en {{ $anio }}',
                        font: {
                            size: 20,
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Montos ($)'
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
