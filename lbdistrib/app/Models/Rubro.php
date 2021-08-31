<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rubro extends Model {

    public $timestamps = false;

    protected $table = 'rubro';
    
    protected $fillable = ['id', 'nombre', 'image'];

}
