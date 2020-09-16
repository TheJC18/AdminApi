<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string("codigo", 20);
            $table->string("nombre", 75);
            $table->string("correo", 50);
            $table->string("direccion", 150);
            $table->string("contacto", 50);
            $table->string("telefono", 120);
            $table->string("tipo_contribuyente", 50);
            $table->float("retencion", 12,2);
            $table->tinyInteger('estatus')->length(1);	

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
        Schema::dropIfExists('cliente');
    }
}
