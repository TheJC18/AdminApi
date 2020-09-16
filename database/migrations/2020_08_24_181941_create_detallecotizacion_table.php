<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallecotizacionTable extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallecotizacion', function (Blueprint $table) {
            $table->id();

            $table->integer("cantidad")->length(11);
            $table->float("precio_unit", 12,2);
            $table->float("monto", 12,2);

            //Relaciones 
            $table->unsignedBigInteger('codCotizacion')->length(6); // Relación con cliente
            $table->foreign('codCotizacion')->references('codigo')->on('cotizacion')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('codProducto')->length(20); // Relación con cliente
            $table->foreign('codProducto')->references('id')->on('producto')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detallecotizacion');
    }
}
