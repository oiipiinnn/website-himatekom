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
    public static function upload(UploadedFile $file, string $directory = 'images', string $disk = null): string
    {
        // ALWAYS use uploads disk for new uploads to avoid hosting permission issues
        $disk = 'uploads';
        
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($directory, $filename, $disk);
    }

    /**
     * Get the best disk for current environment
     *
     * @return string
     */
    public static function getBestDisk(): string
    {
        // In production/hosting, prefer uploads disk over public
        if (app()->environment('production') || !self::isStorageLinkWorking()) {
            return 'uploads';
        }
        
        return 'public';
    }

    /**
     * Check if storage link is working properly
     *
     * @return bool
     */
    public static function isStorageLinkWorking(): bool
    {
        $publicStoragePath = public_path('storage');
        $storageAppPublic = storage_path('app/public');
        
        // Check if symbolic link exists and points to correct location
        if (is_link($publicStoragePath)) {
            return realpath(readlink($publicStoragePath)) === realpath($storageAppPublic);
        }
        
        // Check if it's a directory (some hosting providers use this)
        if (is_dir($publicStoragePath)) {
            return is_readable($publicStoragePath);
        }
        
        return false;
    }

    /**
     * Delete image file from storage
     *
     * @param string|null $path
     * @param string $disk
     * @return bool
     */
    public static function delete(?string $path, string $disk = null): bool
    {
        if (!$path) {
            return false;
        }

        // Try to delete from both disks to ensure cleanup
        $deleted = false;
        $disksToTry = ['uploads', 'public'];
        
        foreach ($disksToTry as $currentDisk) {
            try {
                if (Storage::disk($currentDisk)->exists($path)) {
                    if (Storage::disk($currentDisk)->delete($path)) {
                        $deleted = true;
                    }
                }
            } catch (\Exception $e) {
                // Continue to next disk if current one fails
                continue;
            }
        }

        return $deleted;
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

        // Smart disk selection and fallback
        $disksToTry = [$disk];
        
        // Add alternative disks for fallback
        if ($disk === 'public') {
            $disksToTry[] = 'uploads';
        } elseif ($disk === 'uploads') {
            $disksToTry[] = 'public';
        }

        foreach ($disksToTry as $currentDisk) {
            try {
                // If path exists in current disk, return URL
                if (Storage::disk($currentDisk)->exists($path)) {
                    if ($currentDisk === 'uploads') {
                        // Generate proper URL for uploads disk
                        return asset('uploads/' . $path);
                    } else {
                        // Use Storage disk URL for others
                        return Storage::disk($currentDisk)->url($path);
                    }
                }
            } catch (\Exception $e) {
                // Continue to next disk if current one fails
                continue;
            }
        }

        // Try direct public path (legacy support)
        if (file_exists(public_path($path))) {
            return asset($path);
        }

        // Try uploads directory directly
        $uploadsPath = 'uploads/' . $path;
        if (file_exists(public_path($uploadsPath))) {
            return asset($uploadsPath);
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

    /**
     * Debug image URL generation
     *
     * @param string|null $path
     * @param string $disk
     * @return array
     */
    public static function debugImageUrl(?string $path, string $disk = 'public'): array
    {
        $debug = [
            'input_path' => $path,
            'input_disk' => $disk,
            'final_url' => null,
            'checks' => []
        ];

        if (!$path) {
            $debug['checks'][] = 'Path is empty, using default image';
            $debug['final_url'] = self::getDefaultImage();
            return $debug;
        }

        // Check uploads disk
        try {
            if (Storage::disk('uploads')->exists($path)) {
                $debug['checks'][] = 'Found in uploads disk';
                $debug['final_url'] = asset('uploads/' . $path);
                return $debug;
            } else {
                $debug['checks'][] = 'Not found in uploads disk';
            }
        } catch (\Exception $e) {
            $debug['checks'][] = 'Uploads disk error: ' . $e->getMessage();
        }

        // Check public disk
        try {
            if (Storage::disk('public')->exists($path)) {
                $debug['checks'][] = 'Found in public disk';
                $debug['final_url'] = Storage::disk('public')->url($path);
                return $debug;
            } else {
                $debug['checks'][] = 'Not found in public disk';
            }
        } catch (\Exception $e) {
            $debug['checks'][] = 'Public disk error: ' . $e->getMessage();
        }

        // Check direct public path
        if (file_exists(public_path($path))) {
            $debug['checks'][] = 'Found in direct public path';
            $debug['final_url'] = asset($path);
            return $debug;
        } else {
            $debug['checks'][] = 'Not found in direct public path';
        }

        $debug['checks'][] = 'File not found anywhere, using default';
        $debug['final_url'] = self::getDefaultImage();

        return $debug;
    }
}