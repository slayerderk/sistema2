<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->integer('id')->unsigned(); //la propiedad UNSIGNED, es para indicar q es una LLAVE FORANEA
            $table->string('contacto',50)->nullable();
            $table->string('telefono_contacto',50)->nullable();
            
            $table->foreign('id')->references('id')->on('personas')->onDelete('cascade');
            //Eto hace relacionar a la tabla PROVEEDORES con la tabla PERSONA 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedores');
    }
}
