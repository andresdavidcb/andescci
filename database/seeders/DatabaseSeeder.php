<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curso;
use App\Models\Calendario;
use App\Models\Empresa;
use App\Models\Alumno;
use App\Models\User;
use App\Models\Inscripcion;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create();
        Alumno::factory(1200)->create();
        Curso::factory(150)->create();
        Empresa::factory(50)->create();
        Calendario::factory(400)->create();
        Inscripcion::factory(3000)->create();
    }
}
