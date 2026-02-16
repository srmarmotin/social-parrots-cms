<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvatarResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image_full_url' => $this->image_full_url,
            'thumbnail_full_url' => $this->thumbnail_full_url,
        ];
    }
}
