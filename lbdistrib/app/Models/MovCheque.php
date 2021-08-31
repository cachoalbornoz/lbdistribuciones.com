<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovCheque extends Model
{
    protected $table = 'mov_cheque';

    protected $fillable = [
        'id', 
        'contacto', 
        'tipocomprobante', 
        'idcomprobante' , 
        'nrocheque',
        'fechacobro', 
        'fechapago', 
        'recibo',
        'pagado',
        'banco', 
        'importe', 
        'cobrado', 
        'observacion', 
        'observacionpago'
    ];

    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco', 'id');
    }

    public function contacto()
    {
        return $this->belongsTo(Contacto::class, 'contacto', 'id');
    }

    public function scopeBuscarbanco($query, $banco)
    {
        if ($banco) {
            return $query->where('banco', $banco);
        }
    }

    public function scopeBuscarfechas($query, $desde, $hasta)
    {
        if ($desde and $hasta) {
            return $query->whereBetween('fechacobro', [$desde, $hasta]);
        }
    }
}
