<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model {

    public $timestamps = false;

    protected $table = 'detalle_pedido';
    
    protected $fillable = ['id', 'producto', 'pedido', 'precio', 'cantidad', 'descuento', 'montodesc', 'iva', 'subtotal', 'cantidadentregada'];


    public function producto() {
        return $this->belongsTo(\App\Models\Producto::class, 'producto', 'id');
    }

    public function pedido() {
        return $this->belongsTo(\App\Models\Pedido::class, 'pedido', 'id');
    }

}
