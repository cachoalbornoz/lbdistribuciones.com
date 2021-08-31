<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePresupuestop extends Model {

    public $timestamps = false;

    protected $table = 'detalle_presupuestop';
    
    protected $fillable = ['id', 'producto', 'presupuestop', 'precio', 'cantidad', 'descuento', 'montodesc', 'iva', 'subtotal', 'cantidadentregada'];


    public function producto() {
        return $this->belongsTo(\App\Models\Producto::class, 'producto', 'id');
    }

    public function presupuestop() {
        return $this->belongsTo(\App\Models\Presupuestop::class, 'presupuestop', 'id');
    }

}
