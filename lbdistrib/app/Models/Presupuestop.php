<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presupuestop extends Model {

    protected $table = 'presupuestop';

    protected $fillable = ['id', 'tipocomprobante', 'proveedor', 'fecha', 'total', 'descuento', 'formapago', 'observaciones', 'estado'];

    public function tipocomprobante() {
        return $this->belongsTo(TipoComprobante::class, 'tipocomprobante', 'id');
    }

    public function proveedor() {
        return $this->belongsTo(Proveedor::class, 'proveedor', 'id');
    }

    public function formapago() {
        return $this->belongsTo(TipoFormapago::class, 'formapago', 'id');
    }

    public function productos() {
        return $this->belongsToMany(Producto::class, 'detalle_presupuestop', 'presupuestop', 'producto');
    }

    public function detallepresupuesto() {
        return $this->hasMany(DetallePresupuestop::class, 'presupuestop', 'id');
    }

    public function scopeactivo($query){
        return $query->where('estado', NULL);
    }

    public function scopefacturado($query){
        return $query->where('estado', 1);
    }


}
