<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    

        public $timestamps= false;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function conquistador(){
        return $this->hasOne('App\Conquistador', 'id', 'id_conquistador');
    }
    public function roles(){
        return $this->hasOne('App\Rol', 'id', 'id_rol');
    }
    public function unidad(){
        return $this->hasOne('App\Unidad', 'id', 'unidad_cargo');
    }
}
