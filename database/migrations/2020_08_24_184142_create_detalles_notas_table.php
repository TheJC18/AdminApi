<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallesNotas', function (Blueprint $table) {
            $table->id();

            $table->float("cantidad");
            $table->double("precio");

            $table->unsignedBigInteger('producto')->length(20); // Relación con cliente
            $table->foreign('producto')->references('id')->on('producto')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('nota')->length(20); // Relación con cliente
            $table->foreign('nota')->references('codigo')->on('notasalida')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('detallesNotas');
    }
}
