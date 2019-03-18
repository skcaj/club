<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    //

    public function unidad(){
        return $this->hasOne('App\Unidad', 'id', 'id_unidad');
    }
   
    public function User(){
        return $this->hasOne('App\User', 'id', 'id_usuario');
    }

}
