<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model {

    use SoftDeletes;

    protected $table = 'producto';

    protected $dates = ['deleted_at'];

    protected $fillable = ['id', 'codigobarra', 'nombre', 'descripcion', 'preciolista', 'precioventa', 'stockaviso', 'stockactual', 'rubro', 'marca', 'image', 'bonificacion', 'flete', 'margen', 'actdolar'];

    public function rubro() {
        return $this->belongsTo(Rubro::class, 'rubro', 'id');
    }

    public function marca() {
        return $this->belongsTo(Marca::class, 'marca', 'id');
    }

    public function proveedores(){
        return $this->belongsToMany(Proveedor::class);
    }

    public function scopebuscarnombre($query, $palabra)
    {
        if ($palabra)
            return $query->where('nombre', 'LIKE', "%$palabra%");

    }

    public function scopebuscarmarca($query, $marca)
    {
        if ($marca) {
            return $query->where('marca', $marca);
        }
    }

    
    public function scopebuscarrubro($query, $rubro)
    {
        if ($rubro) {
            return $query->where('rubro', $rubro);
        }
    }

    public function scopeactivo($query, $activo)
    {
        if ($activo) {
            return $query->where('activo', $activo);
        }
    }

}
