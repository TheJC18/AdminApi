<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdencompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordencompra', function (Blueprint $table) {
            
            $table->bigIncrements("codigo")->length(6);
            $table->float("subtotal", 12,2);
            $table->float("impuesto", 12,2);
            $table->float("total", 12,2);
            $table->string("forma_pago", 120);
            $table->string("tiempo_entrega", 120);
            $table->string("validez", 120);
            $table->string("nota", 250);

            $table->tinyInteger('estatus')->length(1);	

            //Relaciones 
            $table->unsignedBigInteger('cod_proveedor')->length(50); // Relación con cliente
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
        Schema::dropIfExists('ordencompra');
    }
}
