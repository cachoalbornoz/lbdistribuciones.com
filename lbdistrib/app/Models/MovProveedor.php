<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovProveedor extends Model {

    protected $table = 'mov_proveedor';

    protected $fillable = ['id', 'proveedor', 'tipocomprobante', 'fecha', 'concepto', 'nro', 'debe', 'haber', 'producto'];

    public function proveedor() {
        return $this->belongsTo(\App\Models\Proveedor::class, 'proveedor', 'id');
    }

    public function tipocomprobante() {
        return $this->belongsTo(\App\Models\TipoComprobante::class, 'tipocomprobante', 'id');
    }

    public function producto() {
        return $this->belongsTo(\App\Models\Producto::class, 'producto', 'id');
    }


}
