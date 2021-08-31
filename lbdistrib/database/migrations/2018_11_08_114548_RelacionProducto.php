<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelacionProducto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detalle_compra', function (Blueprint $table) {            
            $table->foreign('producto')->references('id')->on('producto')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('detalle_pedido', function (Blueprint $table) {            
            $table->foreign('producto')->references('id')->on('producto')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('detalle_venta', function (Blueprint $table) {            
            $table->foreign('producto')->references('id')->on('producto')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('pendiente', function (Blueprint $table) {            
            $table->foreign('producto')->references('id')->on('producto')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('producto_proveedor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('producto_id');
            $table->integer('proveedor_id');

            $table->foreign('producto_id')->references('id')->on('producto')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('proveedor_id')->references('id')->on('proveedor')->onDelete('cascade')->onUpdate('cascade');
        });
    }
}
