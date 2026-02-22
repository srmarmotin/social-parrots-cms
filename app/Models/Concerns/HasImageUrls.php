<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;

trait HasImageUrls
{
    protected function imageDisk(): string
    {
        return property_exists($this, 'imageDisk')
            ? $this->imageDisk
            : 'public';
    }

    public function getImageFullUrlAttribute(): ?string
    {
        return $this->image_url
            ? Storage::disk($this->imageDisk())->url($this->image_url)
            : null;
    }

    public function getThumbnailFullUrlAttribute(): ?string
    {
        return $this->thumbnail_url
            ? Storage::disk($this->imageDisk())->url($this->thumbnail_url)
            : null;
    }
}
