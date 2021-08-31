<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model {

    protected $table = 'marca';

    protected $fillable = ['id', 'nombre', 'image'];

    public function proveedores(){
        return $this->belongsToMany(Proveedor::class);
    }

}
