<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleordencompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalleordencompra', function (Blueprint $table) {
            $table->id();

            $table->integer("cantidad")->length(11);
            $table->float("precio_unit", 12,2);
            $table->float("monto", 12,2);

            //Relaciones
            $table->unsignedBigInteger('cod_producto')->length(20); // Relación con producto
            $table->foreign('cod_producto')->references('id')->on('producto')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('cod_orden')->length(20); // Relación con orden de compra
            $table->foreign('cod_orden')->references('codigo')->on('ordencompra')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('detalleordencompra');
    }
}
