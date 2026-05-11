<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'eskul',      
        'kelas',      
        'admin_code', 
    ];

    protected $attributes = [
        'role' => 2,
        'kelas' => '-',
        'eskul' => '-', 
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'integer',
        ];
    }

    public function isAdmin(): bool { return $this->role === 0; }
    public function isPembina(): bool { return $this->role === 1; }
    public function isSiswa(): bool { return $this->role === 2; }
}