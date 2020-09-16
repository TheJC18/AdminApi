<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedor', function (Blueprint $table) {
            $table->bigIncrements("id");

            $table->integer("codigo")->length(50);
            $table->string("nombre", 150);
            $table->string("correo", 150);
            $table->string("direccion", 300);
            $table->string("contacto", 50);
            $table->string("telefono", 120);
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
        Schema::dropIfExists('proveedor');
    }
}
