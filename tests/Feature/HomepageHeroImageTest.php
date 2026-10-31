<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomepageHeroImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_logo_and_hero_uploads_use_the_current_host_with_stale_disk_urls(): void
    {
        Storage::fake('uploads', ['url' => 'http://127.0.0.1:8000/uploads']);
        $this->actingAs(User::factory()->create());

        $this->post(route('admin.site-settings.logo.store'), [
            'logo' => UploadedFile::fake()->image('logo.png'),
        ])->assertSessionHasNoErrors();
        $this->post(route('admin.site-settings.home-hero-image.store'), [
            'hero_images' => [UploadedFile::fake()->image('hero.jpg')],
        ])->assertSessionHasNoErrors();

        Storage::disk('uploads')->assertExists(SiteSetting::logoPath());
        $heroPath = SiteSetting::heroImagePaths()[0];
        Storage::disk('uploads')->assertExists($heroPath);

        $this->get('https://aurix.example/')->assertOk()
            ->assertSee('src="https://aurix.example/uploads/'.SiteSetting::logoPath().'"', false)
            ->assertSee('src="https://aurix.example/uploads/'.$heroPath.'"', false)
            ->assertDontSee('http://127.0.0.1:8000/uploads');
    }

    public function test_logo_and_hero_recover_legacy_storage_paths(): void
    {
        Storage::fake('uploads');
        Storage::fake('public');
        Storage::disk('public')->put('site/logo.png', 'logo');
        Storage::disk('public')->put('hero/photo.jpg', 'hero');
        SiteSetting::setLogoPath('/storage/site/logo.png');
        SiteSetting::setHeroImagePaths(['public/storage/hero/photo.jpg']);

        $this->get('/')->assertOk()
            ->assertSee(asset('uploads/site/logo.png'), false)
            ->assertSee(asset('uploads/hero/photo.jpg'), false);
        Storage::disk('uploads')->assertExists('site/logo.png');
        Storage::disk('uploads')->assertExists('hero/photo.jpg');
    }

    public function test_uploaded_hero_images_replace_even_a_saved_video(): void
    {
        Storage::fake('uploads');
        SiteSetting::setHeroVideoUrl('https://youtu.be/dQw4w9WgXcQ');

        $this->actingAs(User::factory()->create())
            ->from(route('admin.home-page-content.index'))
            ->post(route('admin.site-settings.home-hero-image.store'), [
                'hero_images' => [UploadedFile::fake()->image('hero.jpg'), UploadedFile::fake()->image('second.jpg')],
            ])
            ->assertRedirect(route('admin.home-page-content.index'))
            ->assertSessionHasNoErrors();

        $this->assertCount(2, SiteSetting::heroImagePaths());
        foreach (SiteSetting::heroImagePaths() as $path) {
            Storage::disk('uploads')->assertExists($path);
        }

        $response = $this->get('/')->assertOk();
        foreach (SiteSetting::heroImageUrls() as $url) {
            $response->assertSee($url, false);
        }
        $response->assertSee('data-hero-images', false)
            ->assertDontSee('<iframe', false)
            ->assertDontSee('taf-hero-play', false);

        $this->get(route('admin.home-page-content.index'))->assertOk()
            ->assertSee('Upload Hero Images')
            ->assertDontSee('YouTube Video URL');
    }

    public function test_homepage_shows_default_image_without_uploads(): void
    {
        $this->get('/')->assertOk()
            ->assertSee(asset('images/aurix-branding-collage.png'), false)
            ->assertDontSee('<iframe', false);
    }
}

