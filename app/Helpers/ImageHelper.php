<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    public static function getImageUrl($path, $default = null)
    {
        $defaultPlaceholder = $default ?? asset('images/placeholder.svg');
        
        if (empty($path)) {
            return $defaultPlaceholder;
        }

        // Remove any leading slashes
        $path = ltrim($path, '/');

        // Check if it's already a full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Check if file exists in storage
        $storagePath = 'public/' . $path;
        if (Storage::exists($storagePath)) {
            return asset('storage/' . $path);
        }

        // Check if file exists in public directory
        $publicPath = public_path($path);
        if (file_exists($publicPath)) {
            return asset($path);
        }

        // Return default if file doesn't exist
        return $defaultPlaceholder;
    }
}
