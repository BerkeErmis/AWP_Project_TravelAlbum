<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    // Her trip bir kullanıcıya (admin) aittir
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Bir gezinin birden fazla yorumu olabilir
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Bir gezinin birden fazla beğenisi olabilir
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
