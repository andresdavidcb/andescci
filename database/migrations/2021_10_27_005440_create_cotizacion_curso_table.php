<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionCursoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion_curso', function (Blueprint $table) {
            $table->integer('curso_id_curso')->unsigned();
            $table->foreignId('cotizacion_id_cotizacion')->constrained('cotizacions', 'id_cotizacion')->onDelete('cascade');
            $table->enum('modalidad', ['On-Line', 'Presencial']);
            $table->smallInteger('cantidad_alumnos');
            $table->integer('valor_alumno');
            $table->integer('valor_actividad');
            $table->string('nota_aprobacion', 4);

            $table->foreign('curso_id_curso')->references('id_curso')->on('cursos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotizacion_curso');
    }
}
