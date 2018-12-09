<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ImageBencana extends Model
{
    protected $table = "tabel_image_bencana";
    protected $fillable = [
        'path',
        'bencana_id'
    ];

    public static $validation_role = [
        'path' => 'required',
        'bencana_id' => 'required'
    ];

    protected $hidden = array('created_at', 'updated_at');

    public function bencana(){
        return $this->belongsTo(Bencana::class, 'bencana_id', 'id');
    }
}
