<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model {

    public $timestamps = false;

    protected $table = 'compra';
    
    protected $fillable = [
        'id', 
        'tipocomprobante', 
        'proveedor', 
        'fecha', 
        'nro', 
        'total', 
        'formapago',
        'recibo', 
        'pagada', 
        'fechapago', 
        'orden', 
        'autorizada', 
        'fechaautorizacion', 
        'presupuesto', 
        'observaciones'
    ];


    public function proveedor() {
        return $this->belongsTo(\App\Models\Proveedor::class, 'proveedor', 'id');
    }

    public function tipocomprobante() {
        return $this->belongsTo(\App\Models\TipoComprobante::class, 'tipocomprobante', 'id');
    }

    public function formapago() {
        return $this->belongsTo(\App\Models\TipoFormapago::class, 'formapago', 'id');
    }

    public function productos() {
        return $this->belongsToMany(\App\Models\Producto::class, 'detalle_compra', 'compra', 'producto');
    }

    public function detallecompras() {
        return $this->hasMany(\App\Models\DetalleCompra::class, 'compra', 'id');
    }


}