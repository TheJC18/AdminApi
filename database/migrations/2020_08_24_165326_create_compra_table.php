<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra', function (Blueprint $table) {
            $table->bigIncrements("codigo")->length(6);            
            $table->integer("cod_documento")->length(50);
            $table->integer("num_control")->length(50);
            $table->date("fecha_documento");
            $table->float("sub_total", 12,2);
            $table->float("impuesto", 12,2);
            $table->float("total", 12,2);
            $table->string("nota", 600);

            $table->tinyInteger('estatus')->length(1);	

            //Relaciones 
            $table->unsignedBigInteger('cod_proveedor')->length(50); // Relación con proveedor
            $table->foreign('cod_proveedor')->references('id')->on('proveedor')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('usuario')->length(50); // Relación con cliente
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
        Schema::dropIfExists('compra');
    }
}
