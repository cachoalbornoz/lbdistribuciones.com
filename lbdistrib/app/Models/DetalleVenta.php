<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model {

	public $timestamps = false;

    protected $table = 'detalle_venta';

    protected $fillable = ['id', 'producto', 'venta', 'precio', 'cantidad', 'descuento', 'montodesc', 'iva', 'subtotal', 'cantidadentregada'];

    public function producto() {
        return $this->belongsTo(\App\Models\Producto::class, 'producto', 'id');
    }
 
    public function venta() {
        return $this->belongsTo(\App\Models\Venta::class, 'venta', 'id');
    }

}
