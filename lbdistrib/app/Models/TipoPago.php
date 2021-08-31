<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPago extends Model {

    public $timestamps = false;

    protected $table = 'tipo_pago';
    
    protected $fillable = ['id', 'tipopago', 'activa'];


    public function cobros() {
        return $this->belongsToMany(\App\Models\Cobro::class, 'detalle_cobro', 'tipopago', 'cobro');
    }

    public function pagos() {
        return $this->belongsToMany(\App\Models\Pago::class, 'detalle_pago', 'tipopago', 'pago');
    }

    public function detallecobros() {
        return $this->hasMany(\App\Models\DetalleCobro::class, 'tipopago', 'id');
    }

    public function detallepagos() {
        return $this->hasMany(\App\Models\DetallePago::class, 'tipopago', 'id');
    }


}
