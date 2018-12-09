<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $table = "tabel_kabupaten";
    protected $fillable = [
        'nama'
    ];

    protected $hidden = array('created_at', 'updated_at');

    public function desa(){
        return $this->hasMany(Desa::class, 'kabupaten_id');
    }

    public static function boot()
    {
        parent::boot();    
    
        // cause a delete of a kabupaten to cascade to children so they are also deleted
        static::deleted(function($kabupaten)
        {
            $kabupaten->desa()->delete();
        });
    }
}
