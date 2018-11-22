<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminBPBD extends Model
{
    protected $table = "tabel_admin_bpbd";
    protected $fillables = [
        'nama',
        'user_id'
    ];

    public static $validation_role = [
        'nama' => 'required',
        'user_id' => 'required'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}