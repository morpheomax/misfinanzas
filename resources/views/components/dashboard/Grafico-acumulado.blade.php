<div class="w-full mx-auto bg-white shadow-lg rounded-2xl p-4 aspect-video">
    <canvas id="graficoPolar"></canvas>
</div>




<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Obtener el contexto del canvas
        const ctx = document.getElementById('graficoPolar').getContext('2d');

        // Crear el gráfico
        const graficoPolar = new Chart(ctx, {
            type: 'polarArea', // Tipo de gráfico polar
            data: {
                labels: ['Ingresos', 'Egresos', 'Saldo General'], // Etiquetas
                datasets: [{
                    label: 'Totales de Finanzas',
                    data: [{{ $ingresosTotales }}, {{ $egresosTotales }},
                    {{ $saldoGeneral }}], // Los datos de los totales
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
