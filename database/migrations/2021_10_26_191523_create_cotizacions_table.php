<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacions', function (Blueprint $table) {
            $table->id('id_cotizacion');
            $table->string('codigo_cotizacion');
            $table->integer('valor_total');
            $table->date('fecha_cotizacion');
            $table->integer('empresa_id_empresa')->unsigned();
            $table->timestamps();

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
        Schema::dropIfExists('cotizacions');
    }
}
