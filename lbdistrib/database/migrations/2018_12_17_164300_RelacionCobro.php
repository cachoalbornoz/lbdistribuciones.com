<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelacionCobro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cobro_venta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cobro_id');
            $table->integer('venta_id');

            $table->foreign('cobro_id')->references('id')->on('cobro')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('venta_id')->references('id')->on('venta')->onDelete('cascade')->onUpdate('cascade');
        });
    }
}
