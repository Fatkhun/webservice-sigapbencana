<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $table = "tabel_kabupaten";
    protected $fillable = [
        'nama'
    ];

    public function desa(){
        return $this->hasMany(Desa::class, 'kabupaten_id');
    }
}
