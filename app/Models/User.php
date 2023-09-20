<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'name' => 'string',
    ];

    public function getFirstNameAttribute()
    {
        $fullName = $this->name;

        if (strpos($fullName, ' ') === false) {
            return $fullName;
        }

        return explode(' ', $fullName, 2)[0];
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
