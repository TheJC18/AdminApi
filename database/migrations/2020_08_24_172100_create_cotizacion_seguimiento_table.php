<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionSeguimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion_seguimiento', function (Blueprint $table) {
            $table->id();

            $table->string("descripcion", 300);

            //Relaciones 
            $table->unsignedBigInteger('cod_cotizacion')->length(11); // Relación con cliente
            $table->foreign('cod_cotizacion')->references('codigo')->on('cotizacion')->onDelete('cascade')->onUpdate('cascade');

            //Relaciones 
            $table->unsignedBigInteger('usuario')->length(11); // Relación con cliente
            $table->foreign('usuario')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');



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
        Schema::dropIfExists('cotizacion_seguimiento');
    }
}
