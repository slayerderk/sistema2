<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = ['nombre','tipo_documento','num_documento','direccion','telefono','email'];

    public function proveedor()
    {   //hace referencia q una PERSONA esta relacionada con un solo PROVEEDOR
        return $this->hasOne('App\Proveedor'); 
    }

    public function user()
    {   //hace referencia q una PERSONA esta relacionada con un solo PROVEEDOR
        return $this->hasOne('App\User'); 
    }
    
}
