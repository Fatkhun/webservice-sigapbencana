<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StatusBencana extends Model
{
    protected $table = "tabel_status_bencana";
    protected $fillable = [
        'nama'
    ];

    public static $validation_role = [
        'nama' => 'required|string',
    ];

    public function bencana(){
        return $this->hasMany(Bencana::class, 'status_id');
    }

    public static function boot()
    {
        parent::boot();    
    
        // cause a delete of a status to cascade to children so they are also deleted
        static::deleted(function($status)
        {
            $status->bencana()->delete();
        });
    }
}
