<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model {

    protected $table = 'venta';

    protected $fillable = [
        'id', 
        'tipocomprobante', 
        'vendedor', 
        'contacto', 
        'fecha', 
        'nro', 
        'total', 
        'formapago', 
        'pagada', 
        'fechapago', 
        'recibo', 
        'presupuesto', 
        'observaciones', 
        'pedido'
    ];

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

    public function pedido() {
        return $this->belongsTo(Pedido::class, 'pedido', 'id');
    }

    public function presupuesto() {
        return $this->belongsTo(Presupuesto::class, 'presupuesto', 'id');
    }

    public function detalleventas() {
        return $this->hasMany(DetalleVenta::class, 'venta', 'id');
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

    public function scopeBuscarvendedor($query, $vendedor)
    {
        if ($vendedor) {
            return $query->where('vendedor', $vendedor);
        }
    }

    public function cobros(){
        return $this->belongsToMany(Cobro::class);
    }

}
