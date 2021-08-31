<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoComprobante extends Model {

    public $timestamps = false;

    protected $table = 'tipo_comprobante';
    
    protected $fillable = ['id', 'comprobante'];


    public function contactos() {
        return $this->belongsToMany(Contacto::class, 'mov_contacto', 'tipocomprobante', 'contacto');
    }

    public function cobros() {
        return $this->hasMany(Cobro::class, 'tipocomprobante', 'id');
    }

    public function compras() {
        return $this->hasMany(Compra::class, 'tipocomprobante', 'id');
    }

    public function movcontactos() {
        return $this->hasMany(MovContacto::class, 'tipocomprobante', 'id');
    }

    public function movproveedores() {
        return $this->hasMany(MovProveedor::class, 'tipocomprobante', 'id');
    }

    public function pagos() {
        return $this->hasMany(Pago::class, 'tipocomprobante', 'id');
    }

    public function pedidos() {
        return $this->hasMany(Pedido::class, 'tipocomprobante', 'id');
    }

    public function venta() {
        return $this->hasMany(Venta::class, 'tipocomprobante', 'id');
    }


}
