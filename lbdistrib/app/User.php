<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Notifications\ResetPassword;

use Caffeinated\Shinobi\Traits\ShinobiTrait;

class User extends Authenticatable
{
    use Notifiable, ShinobiTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'image'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token',  ];

    public function tieneRol()
    {
        $roles = ' ';
        foreach ($this->roles as $role) {
            $roles = $roles . $role->name . ' ';
        }
        return $roles;
    }

    public function esVendedor()
    {   
        $vendedor = 0;
        foreach ($this->roles as $role) {
            if($role->name == 'Vendedor' OR $role->name == 'vendedor'){
                $vendedor=1;
                break;
            }
        }
        return $vendedor;
    }

    public function roles()
    {
       return $this->belongsToMany( \Caffeinated\Shinobi\Models\Role::class);
    }

    public function marcas() {
        return $this->belongsToMany(\App\Models\Marca::class);
    }

    public function vendedor()
    {
        return $this->hasOne( \App\Models\Vendedor::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

}
