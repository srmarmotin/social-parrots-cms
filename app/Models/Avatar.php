<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $name
 * @property string|null $image_url
 * @property string|null $thumbnail_url
 * @property bool $active
 */
class Avatar extends Model
{
    protected $fillable = [
        'name', 'image_url', 'thumbnail_url', 'active',
    ];

    protected $appends = [
        'image_full_url', 'thumbnail_full_url',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function getImageFullUrlAttribute(): ?string
    {
        return $this->image_url
            ? Storage::disk('public')->url($this->image_url)
            : null;
    }
    
    public function getThumbnailFullUrlAttribute(): ?string
    {
        return $this->thumbnail_url
            ? Storage::disk('public')->url($this->thumbnail_url)
            : null;
    }
}
