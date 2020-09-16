<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenSeguimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_seguimiento', function (Blueprint $table) {
            $table->id();

            $table->integer("descripcion")->length(11);

            //Relaciones 
            $table->unsignedBigInteger('cod_orden')->length(11); // Relación con cliente
            $table->foreign('cod_orden')->references('codigo')->on('ordencompra')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('orden_seguimiento');
    }
}
