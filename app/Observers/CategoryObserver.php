<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class CategoryObserver
{
    /**
     * Handle the Category "saving" event.
     * Generate thumbnail when image_url is set or changed.
     */
    public function saving(Category $category): void
    {
        if ($category->isDirty('image_url') && $category->getRawOriginal('image_url') !== $category->getAttributes()['image_url']) {
            $imageUrl = $category->getAttributes()['image_url'];
            
            if ($imageUrl) {
                $this->generateThumbnail($category, $imageUrl);
            } else {
                // If image is removed, also remove thumbnail
                $this->deleteThumbnail($category);
                $category->thumbnail_url = null;
            }
        }
    }

    /**
     * Handle the Category "deleted" event.
     * Clean up files when category is deleted.
     */
    public function deleted(Category $category): void
    {
        $this->deleteImage($category);
        $this->deleteThumbnail($category);
    }

    /**
     * Generate a 640x360 thumbnail for the category image.
     */
    protected function generateThumbnail(Category $category, string $imagePath): void
    {
        $disk = Storage::disk('public');
        
        if (!$disk->exists($imagePath)) {
            return;
        }

        $image = Image::read($disk->path($imagePath));
        $image->cover(640, 360);

        $pathInfo = pathinfo($imagePath);
        $thumbnailPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_thumb.' . $pathInfo['extension'];

        $image->save($disk->path($thumbnailPath));
        $category->thumbnail_url = $thumbnailPath;
    }

    /**
     * Delete the old thumbnail if it exists.
     */
    protected function deleteThumbnail(Category $category): void
    {
        $oldThumbnail = $category->getRawOriginal('thumbnail_url');
        
        if ($oldThumbnail && Storage::disk('public')->exists($oldThumbnail)) {
            Storage::disk('public')->delete($oldThumbnail);
        }
    }

    protected function deleteImage(Category $category): void
    {
        $imageUrl = $category->getRawOriginal('image_url');
        
        if ($imageUrl && Storage::disk('public')->exists($imageUrl)) {
            Storage::disk('public')->delete($imageUrl);
        }
    }
}
