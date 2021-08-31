<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePago extends Model {

    public $timestamps = false;

    protected $table = 'detalle_pago';
    protected $fillable = ['id', 'pago', 'tipopago', 'concepto', 'importe', 'recargo', 'montorecargo', 'subtotal'];


    public function tipopago() {
        return $this->belongsTo(\App\Models\TipoPago::class, 'tipopago', 'id');
    }

    public function pago() {
        return $this->belongsTo(\App\Models\Pago::class, 'pago', 'id');
    }


}
