<?php

namespace App\Models;

use App\User;

use Illuminate\Database\Eloquent\Model;

class Actualizacion extends Model
{

    public $timestamps = true;

    protected $table = 'actualizacion';

    protected $fillable = ['proveedor', 'rubro', 'marca', 'bonificacion', 'flete', 'margen', 'usuario', 'registros'];


    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor', 'id');
    }

    public function rubro()
    {
        return $this->belongsTo(Rubro::class, 'rubro', 'id');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario', 'id');
    }
}