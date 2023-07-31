<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\carbon;

class InscripcionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'estado' => str_shuffle('01') == 1 ? 'Aprovado' : 'Reprobado',
            'nota_diagnostico' => $this->faker->biasedNumberBetween(1, 7),
            'nota_teorica' => $this->faker->biasedNumberBetween(1, 7),
            'nota_practica' => $this->faker->biasedNumberBetween(1, 7),
            'nota_final' => $this->faker->biasedNumberBetween(1, 7),
            'valido_hasta' => Carbon::today()->addDays(rand(-365, 365)),
            'codigo_unico' => substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"),0, 1).substr(str_shuffle("aBcEeFgHiJkLmNoPqRstUvWxYz0123456789"),0, 10),
            'calendario_id_cal' => $this->faker->biasedNumberBetween(1, 400),
            'empresa_id_empresa' => $this->faker->biasedNumberBetween(1, 50),
            'alumno_id_alumno' => $this->faker->biasedNumberBetween(1, 1200),
        ];
    }
}
