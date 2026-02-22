<?php

namespace App\Models;

use App\Models\Concerns\HasImageUrls;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $image_url
 * @property string|null $thumbnail_url
 * @property bool $active
 */
class Avatar extends Model
{
    use HasImageUrls;

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

}
