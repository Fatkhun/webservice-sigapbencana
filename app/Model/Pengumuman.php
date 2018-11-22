<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = "tabel_pengumuman";
    protected $fillables = [
        'deskripsi', 'kondisi_id'
    ];

    public static $validation_role = [
        'deskripsi' => 'required',
        'kondisi_id' => 'required'
    ];

    public function kondisi_bencana(){
        return $this->belongsTo(KondisiBencana::class, 'kondisi_id', 'id');
    }

    public function pengumuman_desa(){
        return $this->hasMany(PengumumanDesa::class, 'pengumuman_id');
    }
}
