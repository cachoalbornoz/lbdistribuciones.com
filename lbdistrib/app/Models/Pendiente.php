<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendiente extends Model {

    public $timestamps = false;

    protected $table = 'pendiente';
    
    protected $fillable = ['id', 'contacto', 'producto', 'precio', 'cantidad', 'descuento', 'montodesc', 'iva', 'subtotal'];


    public function contacto() {
        return $this->belongsTo(Contacto::class, 'contacto', 'id');
    }

    public function producto() {
        return $this->belongsTo(Producto::class, 'producto', 'id');
    }


}
