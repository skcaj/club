<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id'); 
            $table->string('usuario')->unique();
            $table->string('password');
            $table->integer('id_conquistador')->unsigned();
            $table->foreign('id_conquistador')->references('id')->on('conquistadores');
            $table->integer('id_rol')->unsigned();
            $table->foreign('id_rol')->references('id')->on('roles');
            $table->boolean('condicion')->default(1);
            $table->integer('unidad_cargo')->unsigned();
            $table->foreign('unidad_cargo')->references('id')->on('unidades'); 
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
