<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model {

    protected $table = 'presupuesto';

    protected $fillable = ['id', 'tipocomprobante', 'vendedor', 'fecha', 'contacto', 'total', 'formapago', 'observaciones', 'estado'];

    public function tipocomprobante() {
        return $this->belongsTo(TipoComprobante::class, 'tipocomprobante', 'id');
    }

    public function vendedor() {
        return $this->belongsTo(Vendedor::class, 'vendedor', 'id');
    }

    public function contacto() {
        return $this->belongsTo(Contacto::class, 'contacto', 'id');
    }

    public function formapago() {
        return $this->belongsTo(TipoFormapago::class, 'formapago', 'id');
    }

    public function productos() {
        return $this->belongsToMany(Producto::class, 'detalle_presupuesto', 'presupuesto', 'producto');
    }

    public function detallepresupuesto() {
        return $this->hasMany(DetallePresupuesto::class, 'presupuesto', 'id');
    }

    public function scopeactivo($query){
        return $query->where('estado', NULL);
    }

    public function scopefacturado($query){
        return $query->where('estado', 1);
    }


}
