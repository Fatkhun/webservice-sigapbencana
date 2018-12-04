<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = "tabel_pengumuman";
    protected $fillable = [
        'judul','deskripsi', 'kondisi_id'
    ];

    public static $validation_role = [
        'judul' => 'required|string',
        'deskripsi' => 'required|string',
        'kondisi_id' => 'required|string'
    ];

    public function kondisi_bencana(){
        return $this->belongsTo(KondisiBencana::class, 'kondisi_id', 'id');
    }

    public function pengumuman_desa(){
        return $this->hasMany(PengumumanDesa::class, 'pengumuman_id');
    }

    public static function boot()
    {
        parent::boot();    
    
        // cause a delete of a pengumuman to cascade to children so they are also deleted
        static::deleted(function($pengumuman)
        {
            $pengumuman->pengumuman_desa()->delete();
        });
    }
}
