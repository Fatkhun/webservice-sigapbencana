<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = "tabel_berita";
    protected $fillable = [
        'judul', 'deskripsi', 'bencana_id'
    ];

    public static $validation_role = [
        'judul' => 'required',
        'deskripsi' => 'required',
        'bencana_id' => 'required'
    ];

    public function bencana(){
        return $this->belongsTo(Bencana::class, 'bencana_id', 'id');
    }
}
