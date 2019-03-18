<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiposPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_pagos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombrepagos', 50);
            $table->string('descripcion', 100)->nullable();
            $table->boolean('condicion')->default(1);

           
        });
        DB::table('tipos_pagos')->insert(array('id'=>'1','nombrepagos'=>'Gastos', 'descripcion'=>'Gastos Generales'));
            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipos_pagos');
    }
}
