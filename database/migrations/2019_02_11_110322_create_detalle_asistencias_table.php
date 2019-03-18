<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleAsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_asistencias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_asistencia')->unsigned();
            $table->foreign('id_asistencia')->references('id')->on('asistencias');
            $table->integer('id_conquistador')->unsigned();
            $table->foreign('id_conquistador')->references('id')->on('conquistadores');
            $table->double('cuota');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_asistencias');
    }
}
