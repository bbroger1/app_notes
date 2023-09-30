<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword as PasswordsCanResetPassword;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, PasswordsCanResetPassword;

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

    public function shared(): BelongsToMany
    {
        return $this->belongsToMany(Note::class, 'note_user')->using(NoteUser::class);;
    }
}
