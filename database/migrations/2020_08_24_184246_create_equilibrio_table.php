<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquilibrioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equilibrio', function (Blueprint $table) {
            $table->id();

            $table->integer("codigo")->length(11);
            $table->integer("ano")->length(11);
            $table->integer("mes")->length(11);
            $table->float("monto", 12,2);

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
        Schema::dropIfExists('equilibrio');
    }
}
