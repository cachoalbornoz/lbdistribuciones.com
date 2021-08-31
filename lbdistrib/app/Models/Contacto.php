<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contacto extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'contacto';

    protected $fillable = [
        'id', 
        'nombreempresa', 
        'apellido', 
        'nombres', 
        'email', 
        'cuit', 
        'telefono', 
        'celular', 
        'domicilio', 
        'ciudad', 
        'tiporesponsable', 
        'saldo', 
        'remanente', 
        'vendedor'
    ];

    public function tiporesponsable()
    {
        return $this->belongsTo(TipoResponsable::class, 'tiporesponsable', 'id');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad', 'id');
    }

    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class, 'vendedor', 'id');
    }

    public function tipocomprobantes()
    {
        return $this->belongsToMany(TipoComprobante::class, 'mov_contacto', 'contacto', 'tipocomprobante');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'pendiente', 'contacto', 'producto');
    }

    public function cobros()
    {
        return $this->hasMany(Cobro::class, 'contacto', 'id');
    }

    public function movcontactos()
    {
        return $this->hasMany(MovContacto::class, 'contacto', 'id');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'contacto', 'id');
    }

    public function pendientes()
    {
        return $this->hasMany(Pendiente::class, 'contacto', 'id');
    }

    public function venta()
    {
        return $this->hasMany(Venta::class, 'contacto', 'id');
    }

    public function nombrecompleto() {
        return $this->apellido.' '.$this->nombres;
    }
}
