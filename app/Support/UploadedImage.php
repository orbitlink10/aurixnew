<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class UploadedImage
{
    public static function url(?string $path): ?string
    {
        $path = self::relativePath($path);

        if (! $path) {
            return null;
        }

        $uploads = Storage::disk('uploads');
        if ($uploads->exists($path)) {
            // Local uploads must follow the site's current host and HTTPS scheme,
            // even when the disk's cached URL still points to a development host.
            return asset('uploads/'.$path);
        }

        $sources = [Storage::disk('public')];

        // Older installations kept uploads beside public/, or used a physical
        // public/storage directory instead of the configured public disk.
        foreach ([base_path('uploads'), public_path('storage')] as $root) {
            if (is_dir($root)) {
                $sources[] = Storage::build(['driver' => 'local', 'root' => $root]);
            }
        }

        foreach ($sources as $source) {
            if (! $source->exists($path)) {
                continue;
            }

            try {
                // Copy to the publicly served directory; /storage can be blocked
                // by the hosting configuration even when the original exists.
                $contents = $source->get($path);
                if ($contents !== null && $uploads->put($path, $contents)) {
                    return asset('uploads/'.$path);
                }
            } catch (\Throwable $e) {
                // Leave the original in place if the uploads directory is unwritable.
            }
        }

        return null;
    }

    private static function relativePath(?string $path): ?string
    {
        $path = str_replace('\\', '/', trim((string) $path));

        // Imported records may contain a full URL rather than a disk-relative path.
        // Only its local path is used; no remote files are downloaded.
        if (preg_match('#^(https?:)?//#i', $path)) {
            $path = rawurldecode((string) parse_url($path, PHP_URL_PATH));
        }

        $path = ltrim($path, '/');
        $path = preg_replace('#^(?:storage/app/public/|public/(?:uploads|storage)/|uploads/|storage/)#', '', $path);

        if ($path === '' || preg_match('#[\x00-\x1F:]|(?:^|/)\.{1,2}(?:/|$)#', $path)) {
            return null;
        }

        return $path;
    }
}
