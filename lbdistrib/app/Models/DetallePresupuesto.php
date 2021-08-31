<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePresupuesto extends Model {

    public $timestamps = false;

    protected $table = 'detalle_presupuesto';
    
    protected $fillable = ['id', 'producto', 'presupuesto', 'precio', 'cantidad', 'descuento', 'montodesc', 'iva', 'subtotal', 'cantidadentregada'];


    public function producto() {
        return $this->belongsTo(\App\Models\Producto::class, 'producto', 'id');
    }

    public function presupuesto() {
        return $this->belongsTo(\App\Models\Presupesto::class, 'presupuesto', 'id');
    }

}