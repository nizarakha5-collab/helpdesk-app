<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UserNotification;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'status',
        'verification_code',
        'code_expires_at',

        'avatar_path',
        'phone',
        'type',
        'filiere',
        'annee',
        'departement',
        'cin',
        'cne',
        'date_naissance',
        'google_id',
        'avatar',
        'reset_password_code',
        'reset_password_expires_at',
        'auth_provider',
        'password_initialized_at',
        'speciality',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'code_expires_at' => 'datetime',
        'date_naissance' => 'date',
        'reset_password_expires_at' => 'datetime',
        'password_initialized_at' => 'datetime',
    ];

    public function sentTicketMessages()
    {
        return $this->hasMany(TicketMessage::class, 'sender_id');
    }
    public function notifications()
{
    return $this->hasMany(UserNotification::class)->latest();
}
}