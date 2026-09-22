<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class UploadedImage
{
    public static function url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        $uploads = Storage::disk('uploads');
        if ($uploads->exists($path)) {
            // Local uploads must follow the site's current host and HTTPS scheme,
            // even when the disk's cached URL still points to a development host.
            return asset('uploads/'.$path);
        }

        $public = Storage::disk('public');
        if (! $public->exists($path)) {
            return null;
        }

        try {
            // Keep legacy uploads working on hosts without a storage symlink.
            if ($uploads->put($path, $public->get($path))) {
                return asset('uploads/'.$path);
            }
        } catch (\Throwable $e) {
            // Fall back to the legacy storage URL if copying is unavailable.
        }

        return asset('storage/'.$path);
    }
}
