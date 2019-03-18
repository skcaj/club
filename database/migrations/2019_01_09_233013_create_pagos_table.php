<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_conquistador')->unsigned();
            $table->foreign('id_conquistador')->references('id')->on('conquistadores');
            $table->decimal('monto', 10, 2);
            $table->integer('id_pagos')->unsigned();
            $table->foreign('id_pagos')->references('id')->on('tipos_pagos');
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->integer('ie')->unsigned();
            $table->string('descripcion',256)->nullable();
            $table->integer('id_unidad')->unsigned();
            $table->foreign('id_unidad')->references('id')->on('unidades');
            $table->boolean('condicion')->default(1);
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
        Schema::dropIfExists('pagos');
    }
}
