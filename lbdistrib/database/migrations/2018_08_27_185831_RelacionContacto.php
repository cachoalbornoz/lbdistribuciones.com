<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelacionContacto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::table('cobro', function (Blueprint $table) {            
            $table->foreign('contacto')->references('id')->on('contacto')->onDelete('cascade')->onUpdate('cascade')->change();
        });
        Schema::table('mov_contacto', function (Blueprint $table) {            
            $table->foreign('contacto')->references('id')->on('contacto')->onDelete('cascade')->onUpdate('cascade')->change();
        });
        Schema::table('pedido', function (Blueprint $table) {            
            $table->foreign('contacto')->references('id')->on('contacto')->onDelete('cascade')->onUpdate('cascade')->change();
        });

        Schema::table('pendiente', function (Blueprint $table) {            
            $table->foreign('contacto')->references('id')->on('contacto')->onDelete('cascade')->onUpdate('cascade')->change();
        });
        Schema::table('venta', function (Blueprint $table) {            
            $table->foreign('contacto')->references('id')->on('contacto')->onDelete('cascade')->onUpdate('cascade')->change();
        });
        
    }

    
}
