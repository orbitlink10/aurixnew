<?php

namespace Tests\Unit;

use App\Support\UploadedImage;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class UploadedImageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('uploads');
        Storage::fake('public');
    }

    #[DataProvider('savedPaths')]
    public function test_resolves_legacy_path_formats(string $savedPath): void
    {
        Storage::disk('uploads')->put('products/letterhead.webp', 'image');

        $this->assertSame(asset('uploads/products/letterhead.webp'), UploadedImage::url($savedPath));
    }

    public static function savedPaths(): array
    {
        return array_map(fn ($path) => [$path], [
            'products/letterhead.webp',
            'uploads/products/letterhead.webp',
            '/uploads/products/letterhead.webp',
            'public/uploads/products/letterhead.webp',
            '/storage/products/letterhead.webp',
            'public/storage/products/letterhead.webp',
            'storage/app/public/products/letterhead.webp',
            'uploads\\products\\letterhead.webp',
            'http://127.0.0.1:8000/uploads/products/letterhead.webp',
            'https://aurixbranding.co.ke/storage/products/letterhead.webp?version=1',
        ]);
    }

    #[DataProvider('legacyDirectories')]
    public function test_recovers_images_from_legacy_directories_without_removing_the_original(string $directory): void
    {
        $legacy = Storage::fake('legacy-image-test');
        $legacy->put($directory.'/products/letterhead.webp', 'original photo');
        $basePath = $this->app->basePath();
        $publicPath = $this->app->publicPath();

        try {
            $this->app->setBasePath($legacy->path(''));
            $this->app->usePublicPath($legacy->path('public'));

            $this->assertSame(asset('uploads/products/letterhead.webp'), UploadedImage::url('products/letterhead.webp'));
            $this->assertSame('original photo', Storage::disk('uploads')->get('products/letterhead.webp'));
            $this->assertSame('original photo', $legacy->get($directory.'/products/letterhead.webp'));
        } finally {
            $this->app->setBasePath($basePath);
            $this->app->usePublicPath($publicPath);
        }
    }

    public static function legacyDirectories(): array
    {
        return [['uploads'], ['public/storage']];
    }

    public function test_rejects_paths_outside_image_storage(): void
    {
        foreach (['../.env', 'uploads/../.env', 'https://example.com/uploads/%2e%2e/.env', 'C:\\private\\photo.jpg'] as $path) {
            $this->assertNull(UploadedImage::url($path));
        }
    }
}
