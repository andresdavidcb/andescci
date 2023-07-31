<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programas', function (Blueprint $table) {
            $table->increments('id_programas');
            $table->string('objetivo_general');
            $table->text('programa');
            $table->string('horas_teorica', 4)->nullable();
            $table->string('horas_practica', 4)->nullable();
            $table->timestamps();
            $table->integer('curso_id_curso')->unsigned();

            $table->foreign('curso_id_curso')->references('id_curso')->on('cursos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programas');
    }
}
