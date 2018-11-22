<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $table = "tabel_user";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'email', 'password', 'api_token', 'role_id'
    ];

    public static $validation_role = [
        'nama' => 'required',
        'email' => 'required|unique:users',
        'password' => 'required',
        'role_id' => 'required',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public function users_role(){
        return $this->belongsTo(UsersRole::class,'role_id', 'id');
    }

    public function lurah(){
        return $this->hasOne(Lurah::class,'user_id');
    }

    public function bencana(){
        return $this->hasMany(Bencana::class,'user_id');
    }
}
