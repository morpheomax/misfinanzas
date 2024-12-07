<div class="w-full mx-auto bg-white shadow-lg rounded-2xl p-4 aspect-video min-h-[400px]">
    <canvas id="graficoPolar"></canvas>
</div>




<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Obtener el contexto del canvas
        const ctx = document.getElementById('graficoPolar').getContext('2d');

        // Array para mapear el número del mes al nombre del mes
        const meses = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];

        // Obtener el número de mes y año
        const anio = '{{ $anio }}';
        const mesNumero = {{ $mes ?? 'null' }}; // Suponiendo que $mes es un número entero

        // Determinar si se seleccionó un mes
        const esMesSeleccionado = mesNumero !== null; // Verifica si hay un mes definido
        const mesTexto = esMesSeleccionado ? meses[mesNumero - 1] :
        ''; // Si hay mes, usa el nombre correspondiente

        // Establecer el título dinámicamente
        const textoGrafico = esMesSeleccionado ?
            `Acumulado ${anio} - ${mesTexto}` // Mostrar año y mes si hay selección
            :
            `Acumulado ${anio}`;

        // Crear el gráfico
        const graficoPolar = new Chart(ctx, {
            type: 'polarArea', // Tipo de gráfico polar
            data: {
                labels: ['Ingresos', 'Egresos', 'Saldo General'], // Etiquetas
                datasets: [{
                    label: 'Totales de Finanzas',
                    data: [{{ $ingresosTotales }}, {{ $egresosTotales }},
                        {{ $saldoGeneral }}
                    ], // Los datos de los totales
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)', // Color para Ingresos
                        'rgba(255, 99, 132, 0.2)', // Color para Egresos
                        'rgba(75, 192, 192, 0.2)' // Color para Saldo General
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)', // Borde para Ingresos
                        'rgba(255, 99, 132, 1)', // Borde para Egresos
                        'rgba(75, 192, 192, 1)' // Borde para Saldo General
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true, // Hacer el gráfico responsivo
                maintainAspectRatio: false, // Permite que el gráfico no mantenga una proporción fija
                plugins: {
                    title: {
                        display: true,
                        text: textoGrafico,
                        font: {
                            size: 20,
                            weight: 'bold'
                        },
                        padding: {
                            top: 10,
                            bottom: 20
                        }
                    },
                },
                legend: {
                    position: 'top'
                },
                scale: {
                    ticks: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Actualizar el gráfico cuando se redimensione la ventana
        window.addEventListener('resize', function() {
            graficoPolar.resize();
        });
    });
</script>


<style>
    #graficoPolar {
        width: 100%;
        height: 100%;
    }
</style>
