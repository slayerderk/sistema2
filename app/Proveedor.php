<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $fillable = ['id','contacto','telefono_contacto'];

    public $timestamps = false;

    public function persona()
    {   //hace referencia q un proveedor pertenece a una persona
        return $this->belongsTo('App\Persona'); 
    }
}
