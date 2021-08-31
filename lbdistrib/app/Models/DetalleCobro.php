<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCobro extends Model {

    public $timestamps = false;

    protected $table = 'detalle_cobro';

    protected $fillable = ['id', 'cobro', 'tipopago', 'concepto', 'importe', 'recargo', 'montorecargo', 'subtotal'];

    public function cobro() {
        return $this->belongsTo(\App\Models\Cobro::class, 'cobro', 'id');
    }

    public function tipopago() {
        return $this->belongsTo(\App\Models\TipoPago::class, 'tipopago', 'id');
    }


}
