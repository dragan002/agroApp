<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'viber',
        'whatsapp',
        'onboarding_step',
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
            'onboarding_step'   => 'integer',
        ];
    }

    // Relationships

    public function farmerProfile(): HasOne
    {
        return $this->hasOne(FarmerProfile::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Scopes

    public function scopeFarmers($query)
    {
        return $query->where('role', 'farmer');
    }

    public function scopeActive($query)
    {
        return $query->whereHas('farmerProfile', function ($q) {
            $q->where('is_active', true);
        });
    }

    // Methods

    public function isFarmer(): bool
    {
        return $this->role === 'farmer';
    }

    public function toApiArray(): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'email'          => $this->email,
            'role'           => $this->role,
            'phone'          => $this->phone,
            'viber'          => $this->viber,
            'whatsapp'       => $this->whatsapp,
            'onboardingStep' => $this->onboarding_step,
            'farmerProfile'  => $this->relationLoaded('farmerProfile') && $this->farmerProfile
                ? $this->farmerProfile->toApiArray()
                : null,
        ];
    }
}
