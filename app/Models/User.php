<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'foto',
        'role',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'user_id');
    }

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto && file_exists(storage_path('app/public/' . $this->foto))) {
            return asset('storage/' . $this->foto);
        }

        return asset('images/default-user.png');
    }
}
