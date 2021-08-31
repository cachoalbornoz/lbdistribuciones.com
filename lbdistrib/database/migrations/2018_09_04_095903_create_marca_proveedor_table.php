<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarcaProveedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marca_proveedor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('marca_id');
            $table->integer('proveedor_id');
            $table->timestamps();

            $table->foreign('marca_id')->references('id')->on('marca')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('proveedor_id')->references('id')->on('proveedor')->onDelete('cascade')->onUpdate('cascade');
        });
    }
}
