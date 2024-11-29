<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriaFactory extends Factory
{
    /**
     * El modelo correspondiente a esta factoría.
     *
     * @var string
     */
    protected $model = Categoria::class;

    /**
     * Definir el estado predeterminado de la factoría.
     *
     * @return array
     */
    public function definition()
    {
        // Clasificaciones
        $tipos = [
            'Ingresos Fijos' => [
                'Sueldo mensual', 'Bonos corporativos', 'Renta por alquiler de inmuebles',
                'Jubilación/pensión', 'Dividendos de acciones', 'Intereses bancarios',
                'Pagos de clientes recurrentes', 'Renta por propiedades comerciales', 'Honorarios profesionales fijos',
                'Mantenimiento de propiedades', 'Ingresos por regalías', 'Alquiler de maquinaria',
                'Beneficios del seguro social', 'Renta vitalicia', 'Pagos de licencias de software',
            ],
            'Ingresos Variables' => [
                'Ventas de productos', 'Comisiones por ventas', 'Trabajo freelance', 'Propinas',
                'Ingresos por cursos o talleres', 'Renta por Airbnb', 'Inversiones en criptomonedas',
                'Ganancias por apuestas deportivas', 'Alquiler de espacios eventuales', 'Premios por concursos',
                'Ingresos por referidos', 'Venta de segunda mano', 'Contratos temporales', 'Ganancias en bolsa',
                'Venta de servicios eventuales',
            ],
            'Egresos Fijos' => [
                'Alquiler de vivienda', 'Pago de hipoteca', 'Luz', 'Agua', 'Internet', 'Teléfono fijo o móvil',
                'Préstamos personales', 'Cuotas de crédito', 'Pago de seguros', 'Suscripciones a servicios',
                'Cuotas escolares', 'Membresías de gimnasios', 'Mantenimiento de vivienda', 'Pago de impuestos fijos',
                'Cuotas sindicales',
            ],
            'Egresos Variables' => [
                'Comida en restaurantes', 'Ropa y calzado', 'Mantenimiento del auto', 'Combustible',
                'Vacaciones y viajes', 'Entretenimiento', 'Regalos para cumpleaños', 'Reparaciones del hogar',
                'Compras impulsivas', 'Cuidado personal', 'Medicamentos y consultas médicas', 'Compra de muebles',
                'Insumos para hobbies', 'Donaciones', 'Herramientas o equipos de trabajo',
            ],
        ];

        return [

            'nombre' => $this->faker->randomElement($tipos),
            'user_id' => User::inRandomOrder()->first()->id, // Asocia la categoría a un usuario aleatorio
        ];
    }
}
