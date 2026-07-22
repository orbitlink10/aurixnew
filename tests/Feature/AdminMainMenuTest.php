<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMainMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_content_shows_spacelink_style_menu_list(): void
    {
        $response = $this->actingAs(User::factory()->create())
            ->get(route('admin.home-page-content.index'));

        $response->assertOk();
        $response->assertSee('Menu List');
        $response->assertSee('Add Menu');
        $response->assertSee('Actions');
        $response->assertDontSee('<textarea', false);
    }

    public function test_admin_can_manage_main_menu_items(): void
    {
        SiteSetting::setValue('main_menu_items', json_encode([
            ['label' => 'Shop', 'url' => '/products'],
        ]));

        $this->actingAs(User::factory()->create())
            ->post(route('admin.home-page-content.main-menu.store'), [
                'label' => 'Women',
                'url' => '/products?category=women',
            ])
            ->assertRedirect(route('admin.home-page-content.index'));

        $this->assertSame('Women', SiteSetting::mainMenuItems()[1]['label']);

        $this->actingAs(User::factory()->create())
            ->put(route('admin.home-page-content.main-menu.item.update', 1), [
                'label' => 'Ladies',
                'url' => '/products?category=ladies',
            ])
            ->assertRedirect(route('admin.home-page-content.index'));

        $this->assertSame('Ladies', SiteSetting::mainMenuItems()[1]['label']);

        $this->actingAs(User::factory()->create())
            ->delete(route('admin.home-page-content.main-menu.destroy', 1))
            ->assertRedirect(route('admin.home-page-content.index'));

        $this->assertCount(1, SiteSetting::mainMenuItems());
    }
}
