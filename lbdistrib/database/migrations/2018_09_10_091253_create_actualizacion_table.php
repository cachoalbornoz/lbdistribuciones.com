<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActualizacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actualizacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proveedor');
            $table->integer('rubro');
            $table->integer('marca');
            $table->decimal('bonificacion',5,2)->default(0);
            $table->decimal('flete',5,2)->default(0);
            $table->decimal('margen',5,2)->default(0);
            $table->integer('usuario');
            $table->integer('registros')->default(0);
            $table->timestamps();
        });
    }
}
