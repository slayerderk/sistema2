<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //protected $table = 'categorias';   //se conecta con la tabla, pero no es necesario
    protected $fillable = ['nombre', 'descripcion','condicion']; 

    //relacion de uno a muchos  https://laravel.com/docs/5.6/eloquent-relationships#one-to-many
    public function articulos()
    {
        return $this->hasMany('App\Articulo');
    }   //todo esto indica que una CATEGORIA, pude tener varios articulos
}
