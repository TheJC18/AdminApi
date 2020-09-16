<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionTable extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion', function (Blueprint $table) {
            $table->bigIncrements("codigo")->length(6);
            $table->float("iva", 12,2);
            $table->float("subtotal", 12,2);
            $table->float("total", 12,2);
            $table->string("forma_pago", 120);
            $table->string("tiempo_entrega", 120);
            $table->string("validez", 120);
            $table->string("nota", 250);

            $table->tinyInteger('estatus')->length(1);	

            //Relaciones 
            $table->unsignedBigInteger('cod_cliente')->length(11); // Relación con cliente
            $table->foreign('cod_cliente')->references('id')->on('cliente')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('usuario')->length(50); // Relación con cliente
            $table->foreign('usuario')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('tasa')->length(50); // Relación con cliente
            $table->foreign('tasa')->references('id')->on('dolares')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('cotizacion');
    }
}
