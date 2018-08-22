<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idcategoria')->unsigned(); //la propiedad UNSIGNED, es para indicar q es una LLAVE FORANEA
            $table->string('codigo', 50)->nullable();   //NULLABLE, es para indicar q no es obligatorio
            $table->string('nombre', 100)->unique();    //UNIQUE, es para decir q es unico, no se debe repetir con otro
            $table->decimal('precio_venta', 11, 2);
            $table->integer('stock');
            $table->string('descripcion', 256)->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
 
            $table->foreign('idcategoria')->references('id')->on('categorias'); 
            //aqui se declara q la llave FORANEA DE 'idcategoria', va hacer referencia a la tabla CATEGORIAS con articulos
            //es decir, IDCATEGORIA se va enlazar ccon el ID de la tabla CATEGORIAS
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulos');
    }
}
