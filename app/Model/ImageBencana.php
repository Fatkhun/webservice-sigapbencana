<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ImageBencana extends Model
{
    protected $table = "tabel_image_bencana";
    protected $fillables = [
        'path',
        'bencana_id'
    ];

    public static $validation_role = [
        'path' => 'required',
        'bencana_id' => 'required'
    ];

    public function bencana(){
        return $this->belongsTo(Bencana::class, 'bencana_id', 'id');
    }
}
