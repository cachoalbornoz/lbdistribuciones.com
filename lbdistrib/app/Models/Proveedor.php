<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'proveedor';

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
    ];


    public function tiporesponsable() {
        return $this->belongsTo(\App\Models\TipoResponsable::class, 'tiporesponsable', 'id');
    }

    public function ciudad() {
        return $this->belongsTo(\App\Models\Ciudad::class, 'ciudad', 'id');
    }

    public function compras() {
        return $this->hasMany(\App\Models\Compra::class, 'proveedor', 'id');
    }

    public function movproveedores() {
        return $this->hasMany(\App\Models\MovProveedor::class, 'proveedor', 'id');
    }

    public function pagos() {
        return $this->hasMany(\App\Models\Pago::class, 'proveedor', 'id');
    }

    public function nombrecompleto() {
        return $this->apellido.' '.$this->nombres;
    }

    public function marcas(){
        return $this->belongsToMany(Marca::class);
    }

    public function productos(){
        return $this->belongsToMany(Producto::class);
    }

}
