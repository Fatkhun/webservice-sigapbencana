<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table = "tabel_desa";
    protected $fillable = [
        'nama', 'kabupaten_id'
    ];

    public static $validation_role = [
        'nama' => 'required',
        'kabupaten_id' => 'required'
    ];

    public function kabupaten(){
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id', 'id');
    }

    public function lurah(){
        return $this->hasMany(Lurah::class, 'desa_id');
    }

    public static function boot()
    {
        parent::boot();    
    
        // cause a delete of a desa to cascade to children so they are also deleted
        static::deleted(function($desa)
        {
            $desa->lurah()->delete();
        });
    }

}
