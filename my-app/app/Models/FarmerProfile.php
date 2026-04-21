<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;

class FarmerProfile extends Model
{
    protected $table = 'farmer_profiles';

    protected $fillable = [
        'user_id',
        'farm_name',
        'description',
        'city',
        'address',
        'avatar_path',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // Relationships

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'photoable')->orderBy('position');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'farmer_id')->latest();
    }

    // Scopes

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInCity($query, string $city)
    {
        return $query->where('city', $city);
    }

    public function scopeSearchName($query, string $term)
    {
        return $query->where('farm_name', 'like', "%{$term}%");
    }

    // Accessors

    public function getAvatarUrlAttribute(): ?string
    {
        if (!$this->avatar_path) {
            return null;
        }
        return Storage::disk()->url($this->avatar_path);
    }

    public function getLocationAttribute(): string
    {
        $parts = array_filter([$this->address, $this->city]);
        return implode(', ', $parts);
    }

    // API representations

    public function toApiArray(): array
    {
        $user = $this->relationLoaded('user') ? $this->user : null;

        return [
            'id'          => $this->id,
            'userId'      => $this->user_id,
            'farmName'    => $this->farm_name,
            'description' => $this->description,
            'city'        => $this->city,
            'address'     => $this->address,
            'location'    => $this->location,
            'avatarUrl'   => $this->avatar_url,
            'isActive'    => $this->is_active,
            'createdAt'   => $this->created_at?->toDateString(),
            'photos'      => $this->relationLoaded('photos')
                ? $this->photos->map(fn($p) => $p->toApiArray())->values()->all()
                : [],
            'user'        => $user ? [
                'id'        => $user->id,
                'name'      => $user->name,
                'phone'     => $user->phone,
                'viber'     => $user->viber,
                'whatsapp'  => $user->whatsapp,
            ] : null,
            'products'    => $this->relationLoaded('user') && $user && $user->relationLoaded('products')
                ? $user->products->map(fn($p) => $p->toCardArray())->values()->all()
                : [],
        ];
    }

    public function toCardArray(): array
    {
        return [
            'id'           => $this->id,
            'userId'       => $this->user_id,
            'farmName'     => $this->farm_name,
            'description'  => $this->description,
            'city'         => $this->city,
            'address'      => $this->address,
            'location'     => $this->location,
            'avatarUrl'    => $this->avatar_url,
            'isActive'     => $this->is_active,
            'createdAt'    => $this->created_at?->toDateString(),
            'productCount' => $this->relationLoaded('user') && $this->user
                ? ($this->user->products_count ?? 0)
                : 0,
            'coverPhoto'   => $this->relationLoaded('photos') && $this->photos->isNotEmpty()
                ? $this->photos->first()->toApiArray()
                : null,
            'user'         => $this->relationLoaded('user') && $this->user ? [
                'id'       => $this->user->id,
                'name'     => $this->user->name,
                'phone'    => $this->user->phone,
                'viber'    => $this->user->viber,
                'whatsapp' => $this->user->whatsapp,
            ] : null,
        ];
    }
}
