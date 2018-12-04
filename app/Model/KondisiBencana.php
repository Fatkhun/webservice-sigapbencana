<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KondisiBencana extends Model
{
    protected $table = "tabel_kondisi_bencana";
    protected $fillable = [
        'nama'
    ];

    public static $validation_role = [
        'nama' => 'required|string',
    ];

    public function bencana(){
        return $this->hasMany(Bencana::class, 'kondisi_id');
    }

    public static function boot()
    {
        parent::boot();    
    
        // cause a delete of a kondisi to cascade to children so they are also deleted
        static::deleted(function($kondisi)
        {
            $kondisi->bencana()->delete();
        });
    }
}
