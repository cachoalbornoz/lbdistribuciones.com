<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dolar extends Model
{
    public $timestamps = false;

    protected $table    = 'dolar';
    
    protected $fillable = ['id', 'valoranterior', 'valoractual', 'diferencia'];
}
