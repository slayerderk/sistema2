<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $fillable =[
        'idcategoria','codigo','nombre','precio_venta','stock','descripcion','condicion'
        //se declara los campos de la tabla Articulos, q van a almacenar y recibir los datos
    ];
    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }   //un Articulo, puede pertecer a una Categoria
}
