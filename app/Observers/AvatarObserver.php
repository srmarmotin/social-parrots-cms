<?php

namespace App\Observers;

use App\Models\Avatar;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class AvatarObserver
{
    /**
     * Handle the Avatar "saving" event.
     * Generate thumbnail when image_url is set or changed.
     */
    public function saving(Avatar $avatar): void
    {
        if ($avatar->isDirty('image_url') && $avatar->getRawOriginal('image_url') !== $avatar->getAttributes()['image_url']) {
            $imageUrl = $avatar->getAttributes()['image_url'];
            
            if ($imageUrl) {
                $this->generateThumbnail($avatar, $imageUrl);
            } else {
                // If image is removed, also remove thumbnail
                $this->deleteThumbnail($avatar);
                $avatar->thumbnail_url = null;
            }
        }
    }

    /**
     * Handle the Avatar "deleted" event.
     * Clean up files when avatar is deleted.
     */
    public function deleted(Avatar $avatar): void
    {
        $this->deleteImage($avatar);
        $this->deleteThumbnail($avatar);
    }

    /**
     * Generate a 150x150 thumbnail for the avatar image.
     */
    protected function generateThumbnail(Avatar $avatar, string $imagePath): void
    {
        $disk = Storage::disk('public');
        
        if (!$disk->exists($imagePath)) {
            return;
        }

        $image = Image::read($disk->path($imagePath));
        $image->cover(150, 150);

        $pathInfo = pathinfo($imagePath);
        $thumbnailPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_thumb.' . $pathInfo['extension'];

        $image->save($disk->path($thumbnailPath));
        $avatar->thumbnail_url = $thumbnailPath;
    }

    /**
     * Delete the old thumbnail if it exists.
     */
    protected function deleteThumbnail(Avatar $avatar): void
    {
        $oldThumbnail = $avatar->getRawOriginal('thumbnail_url');
        
        if ($oldThumbnail && Storage::disk('public')->exists($oldThumbnail)) {
            Storage::disk('public')->delete($oldThumbnail);
        }
    }

    protected function deleteImage(Avatar $avatar): void
    {
        $imageUrl = $avatar->getRawOriginal('image_url');
        
        if ($imageUrl && Storage::disk('public')->exists($imageUrl)) {
            Storage::disk('public')->delete($imageUrl);
        }
    }
}
