<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model {


	public $timestamps = false;

    protected $table = 'vendedor';

    protected $fillable = ['id', 'apellido', 'nombres', 'comision'];

    public function pedidos() {
        return $this->hasMany(Pedido::class, 'vendedor', 'id');
    }

    public function venta() {
        return $this->hasMany(Venta::class, 'vendedor', 'id');
    }

	public function contactos() {
        return $this->hasMany(Contacto::class, 'vendedor', 'id');
    }

    public function nombrecompleto() {
        return $this->apellido.' '.$this->nombres;
    }

}
