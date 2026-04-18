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
        'fresh_today',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price'       => 'decimal:2',
            'fresh_today' => 'boolean',
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
        return $query->where('fresh_today', true);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where('name', 'like', "%{$term}%");
    }

    // Accessors

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
            'freshToday'    => $this->fresh_today,
            'isActive'      => $this->is_active,
            'createdAt'     => $this->created_at?->toDateString(),
            'photos'        => $this->relationLoaded('photos')
                ? $this->photos->map(fn($p) => $p->toApiArray())->values()->all()
                : [],
            'farmer'        => $farmerProfile ? [
                'id'        => $farmerProfile->id,
                'farmName'  => $farmerProfile->farm_name,
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
            'freshToday'    => $this->fresh_today,
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
