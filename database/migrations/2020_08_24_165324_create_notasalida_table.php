<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasalidaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notasalida', function (Blueprint $table) {
            $table->bigIncrements("codigo");
            
            $table->float("total");
            $table->string("nota", 200);

            $table->tinyInteger('estatus')->length(11);
            
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
        Schema::dropIfExists('notasalida');
    }
}
