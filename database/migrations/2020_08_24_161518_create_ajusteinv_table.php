<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAjusteinvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ajusteinv', function (Blueprint $table) {
            $table->bigIncrements("codigo")->length(11);
            $table->string("tipo_ajuste", 20);
            $table->date("fecha");
            $table->string("nota", 200);
            $table->integer("usuario")->length(11);
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
        Schema::dropIfExists('ajusteinv');
    }
}
