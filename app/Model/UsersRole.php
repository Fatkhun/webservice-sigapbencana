<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UsersRole extends Model
{
    protected $table = "tabel_users_role";
    protected $fillable = [
        'nama'
    ];

    public static $validation_role = [
        'nama' => 'required|string'
    ];

    protected $hidden = array('created_at', 'updated_at');

    public function user(){
        return $this->hasMany(User::class, 'role_id');
    }

    public static function boot()
    {
        parent::boot();    
    
        // cause a delete of a role to cascade to children so they are also deleted
        static::deleted(function($role)
        {
            $role->user()->delete();
        });
    }
}
