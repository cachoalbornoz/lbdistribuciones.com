<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoResponsable extends Model {

    public $timestamps = false;

    protected $table = 'tipo_responsable';

    protected $fillable = ['id', 'condicion', 'activa'];


    public function contactos() {
        return $this->hasMany(Contacto::class, 'tiporesponsable', 'id');
    }

    public function proveedores() {
        return $this->hasMany(Proveedor::class, 'tiporesponsable', 'id');
    }


}
