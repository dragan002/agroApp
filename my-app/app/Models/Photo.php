<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    protected $table = 'photos';

    protected $fillable = [
        'photoable_id',
        'photoable_type',
        'path',
        'position',
    ];

    protected function casts(): array
    {
        return [
            'position' => 'integer',
        ];
    }

    // Relationships

    public function photoable(): MorphTo
    {
        return $this->morphTo();
    }

    // Accessors

    public function getUrlAttribute(): string
    {
        return Storage::disk()->url($this->path);
    }

    // API representation

    public function toApiArray(): array
    {
        return [
            'id'       => $this->id,
            'url'      => $this->url,
            'position' => $this->position,
        ];
    }
}
