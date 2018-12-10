<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use App\Model\Lurah;
use App\Model\AdminSar;
use App\Model\AdminBPBD;
use App\Model\Bencana;
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
        'password', 'created_at', 'updated_at'
    ];


    public function users_role(){
        return $this->belongsTo(UsersRole::class,'role_id', 'id');
    }

    public function lurah(){
        return $this->hasOne(Lurah::class,'user_id');
    }

    public function admin_sar(){
        return $this->hasOne(AdminSar::class,'user_id');
    }

    public function admin_bpbd(){
        return $this->hasOne(AdminBPBD::class,'user_id');
    }

    public function bencana(){
        return $this->hasMany(Bencana::class,'users_id');
    }

    public static function boot()
    {
        parent::boot();    
    
        // cause a delete of a user to cascade to children so they are also deleted
        static::deleted(function($user)
        {
            $user->lurah()->delete();
            $user->admin_sar()->delete();
            $user->admin_bpbd()->delete();
            $user->bencana()->delete();
        });
    }
}
