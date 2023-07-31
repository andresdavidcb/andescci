<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContribucionCotizacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contribucion_cotizacion', function (Blueprint $table) {
            $table->foreignId('contribucion_id_contribucion')->constrained('contribucions', 'id_contribucion')->onDelete('cascade');
            $table->foreignId('cotizacion_id_cotizacion')->constrained('cotizacions', 'id_cotizacion')->onDelete('cascade');

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
        Schema::dropIfExists('contribucion_cotizacion');
    }
}
