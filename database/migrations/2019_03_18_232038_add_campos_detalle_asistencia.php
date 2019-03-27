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
            $table->integer('t_puntos')->nullable()->after('p_cuota');
            $table->boolean('s_cuota')->default(1)->after('t_puntos');
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
            $table->dropColumn('puntualidad','uniforme','material','p_cuota','t_puntos','s_cuota'); 
          });
    }
}
