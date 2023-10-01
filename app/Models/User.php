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
use Illuminate\Support\Facades\Auth;

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

    public function profile()
    {
    }

    public function canEdit(Note $note)
    {
        // Se o usuário é o proprietário da nota ou o admin, ele tem permissão para editar
        if ($note->user_id == $this->id || Auth::user()->is_admin == 1) {
            return true;
        }

        // Caso contrário, o usuário não tem permissão para editar
        return false;
    }

    public function canDestroy(Note $note)
    {
        // Se o usuário é o proprietário da nota ou o admin, ele tem permissão para excluir
        if ($note->user_id == $this->id || Auth::user()->is_admin == 1) {
            return true;
        }

        // Caso contrário, o usuário não tem permissão para excluir
        return false;
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
