<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model {

    public $timestamps = false;

    protected $table = 'provincia';

    protected $fillable = ['id', 'nombre'];

    public function departamentos() {
        return $this->hasMany(\App\Models\Departamento::class, 'provincia', 'id');
    }


}
