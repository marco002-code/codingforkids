<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Check if user has administrator role.
     */
    public function isAdmin(): bool
    {
        return in_array(strtolower($this->role ?? 'panitia'), ['admin', 'superadmin']);
    }

    /**
     * Check if user has panitia role.
     */
    public function isPanitia(): bool
    {
        return strtolower($this->role ?? 'panitia') === 'panitia';
    }

    /**
     * Human-friendly role label.
     */
    public function getRoleLabelAttribute(): string
    {
        return $this->isAdmin() ? 'Administrator' : 'Panitia';
    }

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
}
