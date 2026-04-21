<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;
use App\Enums\ProductCategory;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'user_id',
        'category',
        'name',
        'description',
        'price',
        'price_unit',
        'fresh_until',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price'       => 'decimal:2',
            'fresh_until' => 'datetime',
            'is_active'   => 'boolean',
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

    // Scopes

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeFreshToday($query)
    {
        return $query->where('fresh_until', '>', now());
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where('name', 'like', "%{$term}%");
    }

    public function scopeInCity($query, string $city)
    {
        return $query->whereHas('user.farmerProfile', fn($q) => $q->where('city', $city));
    }

    // Accessors

    public function getIsFreshAttribute(): bool
    {
        return $this->fresh_until !== null && $this->fresh_until->isFuture();
    }

    public function getFreshExpiredRecentlyAttribute(): bool
    {
        return $this->fresh_until !== null
            && $this->fresh_until->isPast()
            && $this->fresh_until->diffInHours(now()) <= 48;
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->relationLoaded('photos') && $this->photos->isNotEmpty()) {
            return Storage::disk('public')->url($this->photos->first()->path);
        }
        return null;
    }

    public function getCategoryLabelAttribute(): string
    {
        return ProductCategory::LABELS[$this->category] ?? $this->category;
    }

    // API representations

    public function toApiArray(): array
    {
        $user = $this->relationLoaded('user') ? $this->user : null;
        $farmerProfile = $user && $user->relationLoaded('farmerProfile') ? $user->farmerProfile : null;

        return [
            'id'            => $this->id,
            'userId'        => $this->user_id,
            'category'      => $this->category,
            'categoryLabel' => $this->category_label,
            'name'          => $this->name,
            'description'   => $this->description,
            'price'         => (float) $this->price,
            'priceUnit'     => $this->price_unit,
            'freshToday'           => $this->is_fresh,
            'freshUntil'           => $this->fresh_until?->toISOString(),
            'freshExpiredRecently' => $this->fresh_expired_recently,
            'isActive'             => $this->is_active,
            'createdAt'            => $this->created_at?->toDateString(),
            'photos'        => $this->relationLoaded('photos')
                ? $this->photos->map(fn($p) => $p->toApiArray())->values()->all()
                : [],
            'farmer'        => $farmerProfile ? [
                'id'        => $farmerProfile->id,
                'farmName'  => $farmerProfile->farm_name,
                'city'      => $farmerProfile->city,
                'address'   => $farmerProfile->address,
                'location'  => $farmerProfile->location,
                'avatarUrl' => $farmerProfile->avatar_url,
                'user'      => $user ? [
                    'id'       => $user->id,
                    'name'     => $user->name,
                    'phone'    => $user->phone,
                    'viber'    => $user->viber,
                    'whatsapp' => $user->whatsapp,
                ] : null,
            ] : null,
        ];
    }

    public function toCardArray(): array
    {
        $user = $this->relationLoaded('user') ? $this->user : null;
        $farmerProfile = $user && $user->relationLoaded('farmerProfile') ? $user->farmerProfile : null;

        return [
            'id'            => $this->id,
            'userId'        => $this->user_id,
            'category'      => $this->category,
            'categoryLabel' => $this->category_label,
            'name'          => $this->name,
            'price'         => (float) $this->price,
            'priceUnit'     => $this->price_unit,
            'freshToday'    => $this->is_fresh,
            'freshUntil'    => $this->fresh_until?->toISOString(),
            'thumbnailUrl'  => $this->thumbnail_url,
            'farmer'        => $farmerProfile ? [
                'id'       => $farmerProfile->id,
                'farmName' => $farmerProfile->farm_name,
                'location' => $farmerProfile->location,
                'user'     => $user ? [
                    'id'       => $user->id,
                    'name'     => $user->name,
                    'phone'    => $user->phone,
                    'viber'    => $user->viber,
                    'whatsapp' => $user->whatsapp,
                ] : null,
            ] : null,
        ];
    }
}
