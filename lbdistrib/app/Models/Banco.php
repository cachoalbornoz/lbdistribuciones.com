<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    public $timestamps = false;

    protected $table    = 'banco';
    
    protected $fillable = ['id', 'nombre'];
}
