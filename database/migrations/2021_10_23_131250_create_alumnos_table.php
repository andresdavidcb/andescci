<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->increments('id_alumno');
            $table->string('rut_alumno', 15);
            $table->string('nombre_alumno', 150);
            $table->string('apellido_paterno', 50);
            $table->string('apellido_materno', 50);
            $table->string('no_licencia', 15)->nullable();
            $table->string('tipo_licencia', 16)->nullable();
            $table->date('vencimiento_licencia')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumnos');
    }
}
