<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmpresaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rut_empresa' => substr(str_shuffle("1234567890"),0, 8).substr(str_shuffle("1234567890kK"),0, 1),
            'nombre_empresa' => $this->faker->company(),
            'nombre_contacto' => $this->faker->name(),
            'email_contacto' => $this->faker->safeEmail(),
            'tel_contacto' => '+569'.substr(str_shuffle("1234567890"),0,8),
            'notaPorcentaje' => $this->faker->boolean(),
        ];
    }
}
