<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detalle_asistencia extends Model
{
    protected $table ='detalle_asistencias';
    public $timestamps = false;

    public function conquistador(){
        return $this->hasOne('App\Conquistador', 'id', 'id_conquistador');
    }
    public function unidad(){
        return $this->hasOne('App\Unidad', 'id', 'unidad_cargo');
    }
}
