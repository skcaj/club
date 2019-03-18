<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConquistadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conquistadores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identidad', 20)->nullable();
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->integer('unidad')->unsigned();
            $table->foreign('unidad')->references('id')->on('unidades')->onDelete('cascade');
            $table->string('imagenurl', 200)->nullable();
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
        Schema::dropIfExists('conquistadores');
    }
}
