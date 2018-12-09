<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminSar extends Model
{
    protected $table = "tabel_admin_sar";
    protected $fillable = [
        'nama',
        'user_id'
    ];

    public static $validation_role = [
        'nama' => 'required',
        'user_id' => 'required'
    ];

    protected $hidden = array('created_at', 'updated_at');

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
