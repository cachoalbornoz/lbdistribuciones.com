<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelacionProveedor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // RELACIONES PROVEEDORES
        
        Schema::table('pago', function (Blueprint $table) {            
            $table->foreign('proveedor')->references('id')->on('proveedor')->onDelete('cascade')->onUpdate('cascade')->change();
        });
        Schema::table('mov_proveedor', function (Blueprint $table) {            
            $table->foreign('proveedor')->references('id')->on('proveedor')->onDelete('cascade')->onUpdate('cascade')->change();
        });
        Schema::table('compra', function (Blueprint $table) {            
            $table->foreign('proveedor')->references('id')->on('proveedor')->onDelete('cascade')->onUpdate('cascade')->change();
        });
    }

    
}
