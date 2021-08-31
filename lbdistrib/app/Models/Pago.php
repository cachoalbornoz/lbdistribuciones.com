<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model {

    public $timestamps = false;

    protected $table = 'pago';

    protected $fillable = [
        'id', 
        'tipocomprobante', 
        'proveedor', 
        'fecha', 
        'nro', 
        'total',
        'cerrado'
    ];

    public function proveedor() {
        return $this->belongsTo(\App\Models\Proveedor::class, 'proveedor', 'id');
    }

    public function tipocomprobante() {
        return $this->belongsTo(\App\Models\TipoComprobante::class, 'tipocomprobante', 'id');
    }

    public function tipopagos() {
        return $this->belongsToMany(\App\Models\TipoPago::class, 'detalle_pago', 'pago', 'tipopago');
    }

    public function detallepagos() {
        return $this->hasMany(\App\Models\DetallePago::class, 'pago', 'id');
    }

}
