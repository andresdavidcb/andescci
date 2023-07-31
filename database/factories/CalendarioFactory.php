<?php

namespace Database\Factories;

use App\Models\Calendario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\carbon;

class CalendarioFactory extends Factory
{

    protected $model = Calendario::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'curso_id_curso' => $this->faker->biasedNumberBetween(1, 150),
            'empresa_id_empresa' => $this->faker->biasedNumberBetween(1, 50),
            'fecha_inicio' => Carbon::today()->addDays(rand(-365, 365)),
            'fecha_fin' => Carbon::today()->addDays(rand(-365, 365)),
            'profesor_a_cargo' => $this->faker->name(),
            'rut_profesor' => substr(str_shuffle("1234567890"),0, 8).substr(str_shuffle("1234567890kK"),0, 1),
            'codigo_actividad' => substr(str_shuffle("1234567890"),0, 7),
            'estado_curso' => 'Cerrado',
            'estado_inscripcion' => 'Cerrada',
            'dias_pago' => '60',
            'estado_pago' => str_shuffle("12") == '1' ? 'Pagado' : 'Por Pagar',
            'fecha_limite' => Carbon::today()->addDays(rand(-365, 365)),
        ];
    }
}
