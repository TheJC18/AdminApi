<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallefacturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallefactura', function (Blueprint $table) {
            $table->id();

            $table->integer("codFactura")->length(6);
            $table->integer("cantidad")->length(11);
            $table->float("precio_unit", 12,2);
            $table->float("monto", 12,2);

            $table->unsignedBigInteger('codProducto')->length(20); // Relación con cliente
            $table->foreign('codProducto')->references('id')->on('producto')->onDelete('cascade')->onUpdate('cascade');


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
        Schema::dropIfExists('detallefactura');
    }
}
