<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Lurah extends Model
{
    protected $table = "tabel_lurah";
    protected $fillable = [
        'nama', 'periode', 'alamat', 'image', 'desa_id', 'user_id'
    ];

    public static $validation_role = [
        'nama' => 'required',
        'periode' => 'required',
        'alamat' => 'required',
        'image' => 'required',
        'desa_id' => 'required',
        'user_id' => 'required'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function desa(){
        return $this->belongsTo(Desa::class, 'desa_id', 'id');
    }
}
