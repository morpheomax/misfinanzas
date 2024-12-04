<div class="w-full mx-auto bg-white shadow-lg rounded-2xl p-4 aspect-video ">
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

                    label: 'Egresos Mensuales',
                    data: {!! json_encode($totalesMensuales->values()) !!},
                    backgroundColor: 'rgba(245, 25, 73, 0.2)',
                    borderColor: 'rgba(255, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    title: {
                        display: true, // Muestra el título
                        text: 'Egresos Totales por Mes de {{ $anio }}', // Texto del título
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
                            text: 'Egresos'
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
