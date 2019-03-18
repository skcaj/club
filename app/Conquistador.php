<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class conquistador extends Model
{
    protected $table ='conquistadores';

    public function unidad(){
        return $this->hasOne('App\Unidad', 'id', 'unidad');
    }
}
