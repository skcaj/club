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
            $table->integer('puntualidad')->nullable();
            $table->integer('uniforme')->nullable();
            $table->integer('material')->nullable();
            $table->integer('p_cuota')->nullable();
            $table->integer('t_puntos')->nullable();
            $table->boolean('s_cuota')->default(1);
            
            
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
