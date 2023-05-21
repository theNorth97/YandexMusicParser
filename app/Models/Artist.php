<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $table = 'artists';
    protected $fillable = [
        'name',
        'subscribers_count',
        'listeners_month_count',
        'albums_count',
        'artist_info',
    ];

    // Правила валидации
    public static $rules = [
        'name' => 'required|string',
        'subscribers_count' => 'required|integer',
        'listeners_month_count' => 'required|integer',
        'albums_count' => 'required',
        'artist_info' => 'required',
    ];

    public function track()
    {
        return $this->hasMany(Track::class);
    }
}
