<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
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
        'phone',
        'document',
        'address',
        'city',
        'department',
        'profile_photo',
        'role',
        'is_active',
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

    public function chatbotInteractions()
    {
        return $this->hasMany(ChatbotInteraction::class);
    }

    public function isSuperuser(): bool
    {
        return $this->role === 'superusuario';
    }

    public function isAdministrator(): bool
    {
        return in_array($this->role, ['administrador', 'superusuario'], true);
    }

    public function hasRole(string ...$roles): bool
    {
        return $this->isSuperuser() || in_array($this->role, $roles, true);
    }
}