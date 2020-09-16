<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleajusteinvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalleajusteinv', function (Blueprint $table) {
            $table->id();

            $table->integer("cantidad")->length(11);
            $table->string("descripcion", 150);

            //Relaciones 
            $table->unsignedBigInteger('cod_ajuste')->length(11); // Relación con cliente
            $table->foreign('cod_ajuste')->references('codigo')->on('ajusteinv')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('detalleajusteinv');
    }
}
