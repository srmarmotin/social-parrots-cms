<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    protected function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value !== null
            ? asset('storage/' . ltrim($value, '/'))
            : null,
        );
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value !== null
            ? asset('storage/' . ltrim($value, '/'))
            : null,
        );
    }
}
