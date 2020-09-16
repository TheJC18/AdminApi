<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->bigIncrements("id");

            $table->string("codigo", 20);
            $table->string("departamento", 4);
            $table->string("descripcion", 300);
            $table->tinyInteger('enser')->length(1);	
            $table->double("precio1");
            $table->double("precio2");
            $table->double("precio3");
            $table->integer("cantidad");
            $table->string("imagen", 200);
            $table->tinyInteger('estatus')->length(1);	

            //Relaciones 
            $table->unsignedBigInteger('tipo')->length(11); // Relación con cliente
            $table->foreign('tipo')->references('id')->on('tipoproducto')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('unidad')->length(11); // Relación con cliente
            $table->foreign('unidad')->references('id')->on('unidad')->onDelete('cascade')->onUpdate('cascade');


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
        Schema::dropIfExists('producto');
    }
}
