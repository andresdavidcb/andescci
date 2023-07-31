<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\carbon;

class AlumnoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rut_alumno' => substr(str_shuffle("1234567890"),0, 8).substr(str_shuffle("1234567890kK"),0, 1),
            'nombre_alumno' => $this->faker->firstName(),
            'apellido_materno' => $this->faker->lastName(),
            'apellido_paterno' => $this->faker->lastName(),
            'no_licencia' => substr(str_shuffle("1234567890"),0, 8).substr(str_shuffle("1234567890kK"),0, 1),
            'tipo_licencia' => substr(str_shuffle("BCD"),0,1),
            'vencimiento_licencia' => Carbon::today()->addDays(rand(-365, 365))
        ];
    }
}
