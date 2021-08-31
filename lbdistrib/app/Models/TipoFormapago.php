<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoFormapago extends Model {

    public $timestamps = false;

    protected $table = 'tipo_formapago';
    
    protected $fillable = ['id', 'forma', 'activa'];


    public function compras() {
        return $this->hasMany(\App\Models\Compra::class, 'formapago', 'id');
    }

    public function pedidos() {
        return $this->hasMany(\App\Models\Pedido::class, 'formapago', 'id');
    }

    public function ventas() {
        return $this->hasMany(\App\Models\Venta::class, 'formapago', 'id');
    }


}
