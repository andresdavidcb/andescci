<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscripcionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscripcions', function (Blueprint $table) {
            $table->increments('id_insc');
            $table->enum('estado', ['Aprovado', 'Reprobado', 'En Curso']);
            $table->float('nota_diagnostico', 3, 1)->nullable();
            $table->float('nota_teorica', 3, 1 )->nullable();
            $table->float('nota_practica', 3, 1)->nullable();
            $table->float('nota_final', 3, 1)->nullable();
            $table->date('valido_hasta')->nullable();
            $table->string('codigo_unico');
            $table->integer('alumno_id_alumno')->unsigned();
            $table->integer('calendario_id_cal')->unsigned();
            $table->integer('empresa_id_empresa')->unsigned();
            $table->timestamps();

            $table->foreign('alumno_id_alumno')->references('id_alumno')->on('alumnos');
            $table->foreign('calendario_id_cal')->references('id_cal')->on('calendarios');
            $table->foreign('empresa_id_empresa')->references('id_empresa')->on('empresas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inscripcions');
    }
}
