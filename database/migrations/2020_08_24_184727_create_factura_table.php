<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura', function (Blueprint $table) {
            $table->id();

            $table->integer("codigo")->length(6);
            $table->string("condicion", 20);
            $table->float("porc_impuesto", 12,2);
            $table->float("costo", 12,2);
            $table->float("iva", 12,2);
            $table->float("subtotal", 12,2);
            $table->float("total", 12,2);
            $table->string("observacion", 300);

            $table->tinyInteger('estatus')->length(1);
            
            //Relaciones 
            $table->unsignedBigInteger('cod_cliente')->length(20); // Relación con cliente
            $table->foreign('cod_cliente')->references('id')->on('cliente')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('factura');
    }
}
