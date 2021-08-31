<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model {

    public $timestamps = false;

    protected $table = 'ciudad';
    protected $fillable = ['id', 'departamento', 'nombre', 'codarea', 'codpostal'];


    public function departamento() {
        return $this->belongsTo(Departamento::class, 'departamento', 'id');
    }

    public function contactos() {
        return $this->hasMany(Contacto::class, 'ciudad', 'id');
    }

    public function proveedors() {
        return $this->hasMany(Proveedor::class, 'ciudad', 'id');
    }


}
