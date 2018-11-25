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

    public function user(){
        return $this->hasMany(User::class, 'role_id');
    }
}
