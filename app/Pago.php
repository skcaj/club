<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    //

    public function conquistador(){
        return $this->hasOne('App\Conquistador', 'id', 'id_conquistador');
    }
    public function tpagos(){
        return $this->hasOne('App\Tipo_pago', 'id', 'id_pagos');
    }
    public function User(){
        return $this->hasOne('App\User', 'id', 'id_usuario');
    }
}
