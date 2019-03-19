<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCamposDetalleAsistencia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detalle_asistencias', function (Blueprint $table){
            $table->integer('puntualidad')->nullable()->after('cuota');
            $table->integer('uniforme')->nullable()->after('puntualidad');
            $table->integer('material')->nullable()->after('uniforme');
            $table->integer('p_cuota')->nullable()->after('material');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detalle_asistencias',function(Blueprint $table){
            $table->dropColumn('t_puntos','puntualidad','uniforme','material','p_cuota'); 
          });
    }
}
