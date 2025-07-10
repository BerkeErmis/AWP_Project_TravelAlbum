<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'trip_id',
        'photo_path',
        'caption',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
