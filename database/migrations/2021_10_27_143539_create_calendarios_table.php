<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendarios', function (Blueprint $table) {
            $table->increments('id_cal');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('profesor_a_cargo', 250)->nullable();
            $table->string('rut_profesor', 15)->nullable();
            $table->enum('estado_curso', ['En Curso', 'Cerrado']);
            $table->enum('estado_inscripcion', ['Abierta', 'Cerrada']);
            $table->string('codigo_actividad');
            $table->smallInteger('dias_pago')->default(60);
            $table->enum('estado_pago', ['Pagado', 'Por Pagar'])->default('Por Pagar');
            $table->date('fecha_limite')->nullable();
            $table->date('fecha_orden')->nullable();
            $table->date('fecha_factura')->nullable();
            $table->string('codigo_orden')->nullable();
            $table->string('codigo_factura')->nullable();
            $table->string('path_orden')->nullable();
            $table->string('path_factura')->nullable();
            $table->integer('curso_id_curso')->unsigned();
            $table->integer('empresa_id_empresa')->unsigned();
            $table->timestamps();

            $table->foreign('curso_id_curso')->references('id_curso')->on('cursos');
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
        Schema::dropIfExists('calendarios');
    }
}
