<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CursoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'codigo_curso' => '123'.substr(str_shuffle("1234567890"),0, 7),
            'nombre_curso' => $this->faker->jobTitle(),
            'horas' => substr(str_shuffle("1234567890"),0, 2),
            'vigencia_curso' => '2',
            'sence' => $this->faker->boolean(),
            'manejo_maquinaria' => $this->faker->boolean(),
        ];
    }
}
