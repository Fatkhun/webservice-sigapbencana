<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KondisiBencana extends Model
{
    protected $table = "tabel_kondisi_bencana";
    protected $fillables = [
        'nama'
    ];

    public function bencana(){
        return $this->hasMany(Bencana::class, 'kondisi_id');
    }
}
