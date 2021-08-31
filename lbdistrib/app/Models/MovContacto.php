<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovContacto extends Model
{
    protected $table = 'mov_contacto';

    protected $fillable = ['id', 'contacto', 'tipocomprobante', 'idcomprobante' ,'fecha', 'concepto', 'nro', 'debe', 'haber', 'saldo'];


    public function contacto()
    {
        return $this->belongsTo(Contacto::class, 'contacto', 'id');
    }

    public function tipocomprobante()
    {
        return $this->belongsTo(TipoComprobante::class, 'tipocomprobante', 'id');
    }


    public function scopeBuscarfechas($query, $desde, $hasta)
    {
        if ($desde and $hasta) {
            return $query->whereBetween('fecha', [$desde, $hasta]);
        }
    }
}
