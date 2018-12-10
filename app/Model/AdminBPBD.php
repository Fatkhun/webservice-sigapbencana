<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminBPBD extends Model
{
    protected $table = "tabel_admin_bpbd";
    protected $fillable = [
        'nama',
        'user_id'
    ];

    public static $validation_role = [
        'nama' => 'required',
        'user_id' => 'required'
    ];

    protected $hidden = array('created_at', 'updated_at', 'user_id');

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }  
}
