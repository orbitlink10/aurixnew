<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\WorkCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_displays_dashboard_products(): void
    {
        Product::create([
            'name' => 'Dashboard Branded Hoodie',
            'slug' => 'dashboard-branded-hoodie',
            'price' => 2500,
            'marked_price' => 3000,
            'category_name' => 'Nai Prints',
            'is_active' => false,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Dashboard Branded Hoodie');
        $response->assertSee('KSh 2,500');
        $response->assertDontSee('No dashboard products have been added yet.');
    }

    public function test_homepage_displays_dashboard_work_categories(): void
    {
        WorkCategory::create([
            'name' => 'Corporate Uniforms',
            'item_count' => 12,
            'image_path' => 'work-categories/corporate-uniforms.jpg',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Corporate Uniforms');
        $response->assertSee('12 items');
        $response->assertDontSee('No dashboard categories have been added yet.');
    }

    public function test_homepage_displays_product_categories_when_work_categories_are_empty(): void
    {
        ProductCategory::create([
            'name' => 'Headwear',
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Headwear');
        $response->assertDontSee('No dashboard categories have been added yet.');
    }

    public function test_homepage_derives_categories_from_dashboard_products(): void
    {
        Product::create([
            'name' => 'Executive Gift Box',
            'slug' => 'executive-gift-box',
            'price' => 1800,
            'category_name' => 'Corporate Gifts',
            'is_active' => false,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Corporate Gifts');
        $response->assertSee('1 item');
        $response->assertDontSee('No dashboard categories have been added yet.');
    }
}
