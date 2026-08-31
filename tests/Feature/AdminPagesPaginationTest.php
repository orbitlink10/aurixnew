<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPagesPaginationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_pages_list_has_next_pagination_after_twenty_items(): void
    {
        $user = User::factory()->create();
        $permission = Permission::create([
            'name' => 'Manage blog posts',
            'slug' => 'manage_blogs',
        ]);
        $user->permissions()->attach($permission);

        for ($i = 1; $i <= 21; $i++) {
            BlogPost::create([
                'user_id' => $user->id,
                'title' => 'Seed Page '.$i,
                'slug' => 'seed-page-'.$i,
                'body' => 'Page content '.$i,
                'status' => 'published',
                'content_type' => 'Page',
            ]);
        }

        $response = $this->actingAs($user)->get(route('admin.pages.index'));

        $response->assertOk();
        $response->assertSee('Showing 1-20 of 21 pages');
        $response->assertSee('Page 1 of 2');
        $response->assertSee('Next');
        $response->assertSee('page=2', false);
    }
}
