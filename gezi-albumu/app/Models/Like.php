<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'user_id',
        'trip_id',
    ];

    // Beğeninin sahibi kullanıcı
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Beğeninin ait olduğu gezi
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
