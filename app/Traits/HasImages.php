<?php

namespace App\Traits;

use App\Helpers\ImageHelper;

trait HasImages
{
    /**
     * Get image URL with fallback
     *
     * @param string $attribute
     * @param string|null $fallback
     * @param string $disk
     * @return string
     */
    public function getImageUrl(string $attribute, ?string $fallback = null, string $disk = 'public'): string
    {
        return ImageHelper::getImageUrl($this->$attribute, $disk, $fallback);
    }

    /**
     * Get optimized image URL
     *
     * @param string $attribute
     * @param array $options
     * @return string
     */
    public function getOptimizedImageUrl(string $attribute, array $options = []): string
    {
        return $this->getImageUrl($attribute, null, 'public');
    }

    /**
     * Delete image file when model is deleted
     *
     * @param string $attribute
     * @param string $disk
     * @return bool
     */
    public function deleteImage(string $attribute, string $disk = 'public'): bool
    {
        return ImageHelper::delete($this->$attribute, $disk);
    }

    /**
     * Boot the trait
     */
    protected static function bootHasImages()
    {
        // Auto-delete images when model is deleted
        static::deleting(function ($model) {
            if (property_exists($model, 'imageFields')) {
                foreach ($model->imageFields as $field) {
                    $model->deleteImage($field);
                }
            }
        });
    }
}