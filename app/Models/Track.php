<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $table = 'tracks';
    protected $fillable = ['name', 'duration', 'album'];


    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
