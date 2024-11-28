<div class="w-full mx-auto  bg-white shadow-lg rounded-2xl p-4">
    <canvas id="graficoMensual"></canvas>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('graficoMensual').getContext('2d');
        const graficoMensual = new Chart(ctx, {
            type: 'bar',

            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                    'Septiembre',
                    'Octubre', 'Noviembre', 'Diciembre'
                ],
                datasets: [{

                    label: 'Ingresos Mensuales',
                    data: {!! json_encode($totalesMensuales->values()) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: false, // Muestra el título
                        text: 'Ingresos Totales por Mes de {{ $anio }}', // Texto del título
                        font: {
                            size: 20, // Tamaño de la fuente
                            weight: 'bold' // Peso de la fuente
                        },
                        padding: {
                            top: 10, // Espacio superior
                            bottom: 20 // Espacio inferior
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Ingresos'
                        },

                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString(
                                    'es-CL'); // Cambia el separador a formato chileno
                            }
                        }
                    }
                }
            }
        });
    });
</script>
