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

    public static function logoPath(): ?string
    {
        return static::getValue('site_logo_path');
    }

    public static function setLogoPath(?string $path): void
    {
        static::setValue('site_logo_path', $path);
    }

    public static function logoUrl(): ?string
    {
        $path = static::logoPath();

        return $path ? static::resolveImageUrl($path) : null;
    }

    public static function defaultContactSettings(): array
    {
        return [
            'support_label' => 'For support call',
            'phone' => '+254 700816670',
            'whatsapp_phone' => '254700816670',
            'whatsapp_message' => 'Hello Aurix Branding, I need a quote.',
            'email' => 'info@aurixbranding.co.ke',
            'address' => '',
        ];
    }

    public static function contactSettings(): array
    {
        $defaults = static::defaultContactSettings();

        foreach ($defaults as $key => $default) {
            $defaults[$key] = static::getValue('contact_'.$key, $default);
        }

        return $defaults;
    }

    public static function defaultMainMenuItems(): array
    {
        return [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Shop', 'url' => '/products'],
            ['label' => 'Women', 'url' => '/products?category=women'],
            ['label' => 'Men', 'url' => '/products?category=men'],
            ['label' => 'Outerwear', 'url' => '/products?category=outerwear'],
            ['label' => 'Headwear', 'url' => '/products?category=headwear'],
            ['label' => 'Uniforms', 'url' => '/products?category=uniforms'],
            ['label' => 'Youth', 'url' => '/products?category=youth'],
            ['label' => 'Gifts', 'url' => '/products?category=gifts'],
            ['label' => 'Infant & Toddler', 'url' => '/products?category=infant-toddler'],
            ['label' => 'Embroidery', 'url' => '/embroidery'],
            ['label' => 'Create Design', 'url' => '/create-design'],
            ['label' => 'Brands', 'url' => '/products?category=brands'],
        ];
    }

    public static function mainMenuItems(): array
    {
        $raw = static::getValue('main_menu_items');

        if ($raw) {
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                $items = array_values(array_filter($decoded, fn ($item) => is_array($item) && ! empty($item['label']) && ! empty($item['url'])));
                if (count($items)) {
                    return $items;
                }
            }
        }

        return static::defaultMainMenuItems();
    }

    public static function setMainMenuFromText(?string $value): void
    {
        $lines = preg_split('/\r\n|\r|\n/', (string) $value);
        $items = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            [$label, $url] = array_pad(array_map('trim', explode('|', $line, 2)), 2, null);
            if ($label === '') {
                continue;
            }

            $items[] = [
                'label' => $label,
                'url' => $url ?: static::defaultMainMenuUrlForLabel($label),
            ];
        }

        static::setValue('main_menu_items', count($items) ? json_encode($items) : null);
    }

    protected static function defaultMainMenuUrlForLabel(string $label): string
    {
        return match ((string) str($label)->lower()) {
            'home' => '/',
            'shop' => '/products',
            'embroidery' => '/embroidery',
            'create design' => '/create-design',
            default => '/products?category='.str($label)->slug(),
        };
    }

    public static function mainMenuText(): string
    {
        return collect(static::mainMenuItems())
            ->map(fn ($item) => ($item['label'] ?? '').' | '.($item['url'] ?? ''))
            ->implode("\n");
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
