<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cobro extends Model {

    public $timestamps = false;

    protected $table = 'cobro';

    protected $fillable = ['id', 'tipocomprobante', 'contacto', 'fecha', 'nro', 'total', 'observaciones'];

    public function tipocomprobante() {
        return $this->belongsTo(TipoComprobante::class, 'tipocomprobante', 'id');
    }

    public function contacto() {
        return $this->belongsTo(Contacto::class, 'contacto', 'id');
    }

    public function tipopagos() {
        return $this->belongsToMany(TipoPago::class, 'detalle_cobro', 'cobro', 'tipopago');
    }

    public function detallecobros() {
        return $this->hasMany(DetalleCobro::class, 'cobro', 'id');
    }

    public function scopeBuscarfechas($query, $desde, $hasta)
    {
        if ($desde and $hasta) {
            return $query->whereBetween('fecha', [$desde, $hasta]);
        }
    }

    public function scopeBuscarcontacto($query, $contacto)
    {
        if ($contacto) {
            return $query->where('contacto', $contacto);
        }
    }

    public function ventas(){
        return $this->belongsToMany(Venta::class);
    }

}
