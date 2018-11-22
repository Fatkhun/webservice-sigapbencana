<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StatusBencana extends Model
{
    protected $table = "tabel_status_bencana";
    protected $fillables = [
        'nama'
    ];

    public function bencana(){
        return $this->hasMany(Bencana::class, 'status_id');
    }
}
