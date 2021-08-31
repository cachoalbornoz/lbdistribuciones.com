<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{

    public $timestamps = false;

    protected $table = 'detalle_compra';
    protected $fillable = ['id', 'producto', 'compra', 'precio', 'cantidad', 'descuento', 'montodesc', 'descuento1', 'montodesc1', 'iva', 'montoiva', 'subtotal', 'cantidadentregada'];


    public function compra()
    {
        return $this->belongsTo(\App\Models\Compra::class, 'compra', 'id');
    }

    public function producto()
    {
        return $this->belongsTo(\App\Models\Producto::class, 'producto', 'id');
    }
}