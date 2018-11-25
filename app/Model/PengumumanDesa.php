<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PengumumanDesa extends Model
{
    protected $table = "tabel_pengumuman_desa";
    protected $fillable = [
        'pengumuman_id', 'desa_id'
    ];

    public static $validation_role = [
        'pengumuman_id' => 'required',
        'desa_id' => 'required'
    ];

    public function pengumuman(){
        return $this->belongsTo(Pengumuman::class, 'pengumuman_id', 'id');
    }

    public function desa(){
        return $this->belongsTo(PengumumanDesa::class, 'desa_id', 'id');
    }
}
