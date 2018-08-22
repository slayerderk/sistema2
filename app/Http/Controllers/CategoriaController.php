<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Categoria;
//use App\Http\Controllers\CategoriaController;


class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');    //seguridad mediante AJAX

        //declaracion de variables php
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        //fin** 
        
        /*//paginacion usando Query   (es nesecesario ...\Facades\DB)
        $categorias = DB::table('categorias')->paginate(3);
        return $categorias;
        //paginacion usando Eloquent
        $categorias = Categoria::paginate(3);        
        return $categorias;
        */
        
        if ($buscar==''){
            $categorias = Categoria::orderBy('id', 'desc')->paginate(10);    
            //la variable 'desc' es para mostrar los registros q recien se agregaron en la posicion de inicio  
        }
        else{
            $categorias = Categoria::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(5);
        }
        return [
            'pagination' => [
                'total'        => $categorias->total(),
                'current_page' => $categorias->currentPage(),
                'per_page'     => $categorias->perPage(),
                'last_page'    => $categorias->lastPage(),
                'from'         => $categorias->firstItem(),
                'to'           => $categorias->lastItem(),                
            ],
            'categorias' => $categorias
        ];
    }
    
    public function selectCategoria(Request $request){
        //selecCategoria, obtiene solo a la categorias q estan activas        
        if (!$request->ajax()) return redirect('/');
        $categorias = Categoria::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['categorias' => $categorias];
    }
     
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->condicion = '1';
        $categoria->save();
    }
 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $categoria = Categoria::findOrFail($request->id);   //busca la categoria mediante el ID
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->condicion = '1';
        $categoria->save();
    } 
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $categoria = Categoria::findOrFail($request->id);
        $categoria->condicion = '0';
        $categoria->save();
    } 
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
         
        $catgoria = Categoria::findOrFail($request->id);
        $catgoria->condicion = '1';
        $catgoria->save();
    }
}
