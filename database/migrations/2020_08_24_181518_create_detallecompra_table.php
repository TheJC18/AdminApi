<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallecompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallecompra', function (Blueprint $table) {
            $table->id();

            $table->integer("cantidad")->length(11);
            $table->float("precio_unit", 12,2);
            $table->float("monto", 12,2);

            //Relaciones 
            $table->unsignedBigInteger('cod_compra')->length(6); // Relación con cliente
            $table->foreign('cod_compra')->references('codigo')->on('compra')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('cod_producto')->length(20); // Relación con cliente
            $table->foreign('cod_producto')->references('id')->on('producto')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('detallecompra');
    }
}
