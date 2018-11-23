<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bencana extends Model
{
    protected $table = "tabel_bencana";
    protected $fillables = [
        'alamat', 'luka_luka', 'belum_ditemukan', 'mengungsi', 'meninggal'
        , 'users_id', 'kategori_id', 'status_id',
    ];

    public static $validation_role = [
        'alamat' => 'required|string',
        'luka_luka' => 'required|string',
        'belum_ditemukan' => 'required|string',
        'mengungsi' => 'required|string',
        'meninggal' => 'required|string',
        'users_id' => 'required|string',
        'kategori_id' => 'required|string',
        'status_id' => 'required|string'
    ];

    public function image_bencana(){
        return $this->hasMany(ImageBencana::class, 'bencana_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function kategori_bencana(){
        return $this->belongsTo(KategoriBencana::class, 'kategori_id', 'id');
    }

    public function status_bencana(){
        return $this->belongsTo(StatusBencana::class, 'status_id', 'id');
    }
}
