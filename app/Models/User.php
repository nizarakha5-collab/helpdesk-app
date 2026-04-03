<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'code_expires_at' => 'datetime',
        'date_naissance' => 'date',
    ];

    public function sentTicketMessages()
    {
        return $this->hasMany(TicketMessage::class, 'sender_id');
    }
}