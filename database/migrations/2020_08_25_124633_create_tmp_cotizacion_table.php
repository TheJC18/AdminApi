<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmpCotizacionTable extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmp_cotizacion', function (Blueprint $table) {
            $table->bigIncrements("codigo")->length(6);            
            $table->float("iva", 12,2);
            $table->float("subtotal", 12,2);
            $table->float("total", 12,2);
            $table->string("forma_pago", 50);
            $table->string("tiempo_entrega", 50);
            $table->string("validez", 50);
            $table->string("nota", 250);
            $table->tinyInteger("estatus")->length(1);

            //Relaciones 
            $table->unsignedBigInteger('cod_cliente')->length(20); // Relación con cliente
            $table->foreign('cod_cliente')->references('id')->on('cliente')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('usuario')->length(50); // Relación con cliente
            $table->foreign('usuario')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('tmp_cotizacion');
    }
}
