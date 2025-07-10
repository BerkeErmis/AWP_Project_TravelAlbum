<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Kullanıcı rolü
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Bir kullanıcının birden fazla trip'i olabilir
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    // Bir kullanıcının birden fazla yorumu olabilir
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Bir kullanıcının birden fazla beğenisi olabilir
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
