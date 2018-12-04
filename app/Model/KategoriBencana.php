<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KategoriBencana extends Model
{
    protected $table = "tabel_kategori_bencana";
    protected $fillable = [
        'nama'
    ];

    public static $validation_role = [
        'nama' => 'required|string',
    ];

    public function bencana(){
        return $this->hasMany(Bencana::class, 'kategori_id');
    }

    public static function boot()
    {
        parent::boot();    
    
        // cause a delete of a kategori to cascade to children so they are also deleted
        static::deleted(function($kategori)
        {
            $kategori->bencana()->delete();
        });
    }
}
