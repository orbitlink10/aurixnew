<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageHeroVideoTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_embeds_dashboard_youtube_video(): void
    {
        SiteSetting::setHeroVideoUrl('https://youtu.be/dQw4w9WgXcQ');

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Same day');
        $response->assertSee('T-shirt printing');
        $response->assertSee('Order T-Shirts Now');
        $response->assertSee('youtube.com/embed/dQw4w9WgXcQ', false);
    }

    public function test_admin_can_update_homepage_hero_video(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('admin.home-page-content.hero-video.update'), [
                'hero_video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            ])
            ->assertRedirect(route('admin.home-page-content.index'));

        $this->assertSame('https://www.youtube.com/watch?v=dQw4w9WgXcQ', SiteSetting::heroVideoUrl());
        $this->assertStringContainsString('youtube.com/embed/dQw4w9WgXcQ', SiteSetting::heroVideoEmbedUrl());
    }

    public function test_admin_cannot_save_non_youtube_hero_video_url(): void
    {
        $this->actingAs(User::factory()->create())
            ->from(route('admin.home-page-content.index'))
            ->post(route('admin.home-page-content.hero-video.update'), [
                'hero_video_url' => 'https://example.com/video',
            ])
            ->assertRedirect(route('admin.home-page-content.index'))
            ->assertSessionHasErrors('hero_video_url');

        $this->assertNull(SiteSetting::heroVideoUrl());
    }
}
