<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // Yorumun sahibi kullanıcı
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Yorumun ait olduğu gezi
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
