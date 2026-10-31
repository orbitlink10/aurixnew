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

