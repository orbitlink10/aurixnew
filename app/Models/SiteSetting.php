<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    public static function getValue(string $key, ?string $default = null): ?string
    {
        return static::query()->where('key', $key)->value('value') ?? $default;
    }

    public static function setValue(string $key, ?string $value): void
    {
        if ($value === null || $value === '') {
            static::query()->where('key', $key)->delete();
            return;
        }

        static::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    public static function heroImagePaths(): array
    {
        $raw = static::getValue('home_hero_image_paths');

        if ($raw) {
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                return array_values(array_filter($decoded, fn ($path) => is_string($path) && $path !== ''));
            }
        }

        $legacyPath = static::getValue('home_hero_image_path');
        return $legacyPath ? [$legacyPath] : [];
    }

    public static function setHeroImagePaths(array $paths): void
    {
        $cleaned = array_values(array_unique(array_filter($paths, fn ($path) => is_string($path) && $path !== '')));

        if (count($cleaned) === 0) {
            static::setValue('home_hero_image_paths', null);
            static::setValue('home_hero_image_path', null); // legacy key
            return;
        }

        static::setValue('home_hero_image_paths', json_encode($cleaned));
        static::setValue('home_hero_image_path', $cleaned[0]); // legacy key
    }

    public static function heroImageUrls(): array
    {
        $urls = [];

        foreach (static::heroImagePaths() as $path) {
            $url = static::resolveImageUrl($path);
            if ($url) {
                $urls[] = $url;
            }
        }

        return $urls;
    }

    public static function heroImageUrl(): ?string
    {
        $urls = static::heroImageUrls();
        return $urls[0] ?? null;
    }

    protected static function resolveImageUrl(string $path): ?string
    {
        $uploads = Storage::disk('uploads');
        if ($uploads->exists($path)) {
            return $uploads->url($path);
        }

        $public = Storage::disk('public');
        if ($public->exists($path)) {
            try {
                if (!$uploads->exists($path)) {
                    $uploads->put($path, $public->get($path));
                }
                return $uploads->url($path);
            } catch (\Throwable $e) {
                return asset('storage/'.$path);
            }
        }

        return null;
    }
}
