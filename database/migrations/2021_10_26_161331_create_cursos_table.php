<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->increments('id_curso');
            $table->string('codigo_curso', 15);
            $table->string('nombre_curso', 255);
            $table->smallInteger('horas');
            $table->smallInteger('vigencia_curso');
            $table->boolean('sence');
            $table->boolean('manejo_maquinaria');
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
        Schema::dropIfExists('cursos');
    }
}
