<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHelper
{
    /**
     * Upload image file to specified directory
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string $disk
     * @return string
     */
    public static function upload(UploadedFile $file, string $directory = 'images', string $disk = 'public'): string
    {
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($directory, $filename, $disk);
    }

    /**
     * Delete image file from storage
     *
     * @param string|null $path
     * @param string $disk
     * @return bool
     */
    public static function delete(?string $path, string $disk = 'public'): bool
    {
        if (!$path) {
            return false;
        }

        return Storage::disk($disk)->delete($path);
    }

    /**
     * Get image URL
     *
     * @param string|null $path
     * @param string $disk
     * @param string|null $fallback
     * @return string
     */
    public static function url(?string $path, string $disk = 'public', ?string $fallback = null): string
    {
        if (!$path) {
            return $fallback ?: asset('img/placeholder.jpg');
        }

        // Check if path exists
        if (!Storage::disk($disk)->exists($path)) {
            return $fallback ?: asset('img/placeholder.jpg');
        }

        return Storage::disk($disk)->url($path);
    }

    /**
     * Get optimized image URL with fallback
     *
     * @param string|null $path
     * @param string $disk
     * @param string|null $fallback
     * @param array $options
     * @return string
     */
    public static function getImageUrl(?string $path, string $disk = 'public', ?string $fallback = null, array $options = []): string
    {
        // If no path provided, return fallback
        if (!$path) {
            return $fallback ?: self::getDefaultImage();
        }

        // If path starts with http/https, return as is (external URL)
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        // If path exists in storage, return storage URL
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->url($path);
        }

        // If path exists in public directory (legacy)
        if (file_exists(public_path($path))) {
            return asset($path);
        }

        // Return fallback or default
        return $fallback ?: self::getDefaultImage();
    }

    /**
     * Get default placeholder image
     *
     * @return string
     */
    public static function getDefaultImage(): string
    {
        return asset('img/logo.png');
    }

    /**
     * Validate image file
     *
     * @param UploadedFile $file
     * @param array $rules
     * @return bool
     */
    public static function validate(UploadedFile $file, array $rules = []): bool
    {
        $defaultRules = [
            'max_size' => 2048, // KB
            'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp']
        ];

        $rules = array_merge($defaultRules, $rules);

        // Check file size
        if ($file->getSize() > ($rules['max_size'] * 1024)) {
            return false;
        }

        // Check extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $rules['allowed_extensions'])) {
            return false;
        }

        return true;
    }

    /**
     * Get image dimensions
     *
     * @param string $path
     * @param string $disk
     * @return array|null
     */
    public static function getDimensions(string $path, string $disk = 'public'): ?array
    {
        if (!Storage::disk($disk)->exists($path)) {
            return null;
        }

        $fullPath = Storage::disk($disk)->path($path);
        $imageInfo = getimagesize($fullPath);

        if (!$imageInfo) {
            return null;
        }

        return [
            'width' => $imageInfo[0],
            'height' => $imageInfo[1],
            'mime' => $imageInfo['mime']
        ];
    }
}