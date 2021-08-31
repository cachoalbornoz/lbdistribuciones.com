<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model {

    public $timestamps = false;

    protected $table = 'departamento';

    protected $fillable = ['id', 'provincia', 'nombre'];


    public function provincia() {
        return $this->belongsTo(\App\Models\Provincium::class, 'provincia', 'id');
    }

    public function ciudad() {
        return $this->hasMany(\App\Models\Ciudad::class, 'departamento', 'id');
    }


}
