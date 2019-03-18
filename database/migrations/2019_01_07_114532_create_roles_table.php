<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 30)->unique();
            $table->string('descripcion', 100)->nullable();
            $table->boolean('condicion')->default(1);          
        });
        DB::table('roles')->insert(array('id'=>'1','nombre'=>'Administrador', 'descripcion'=>'Administrador o Tesorero del Club'));
        DB::table('roles')->insert(array('id'=>'2','nombre'=>'Director', 'descripcion'=>'Director o Directora del Club'));
        DB::table('roles')->insert(array('id'=>'3','nombre'=>'Consejero', 'descripcion'=>'Consejero de unidad'));
        DB::table('roles')->insert(array('id'=>'4','nombre'=>'Conquistador', 'descripcion'=>'Conqusitador'));
 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
