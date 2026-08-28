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

    public function test_homepage_shows_work_categories_in_portfolio(): void
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
    }

    public function test_homepage_shows_non_empty_product_categories(): void
    {
        $category = ProductCategory::create(['name' => 'Branded Apparel']);

        Product::create([
            'name' => 'Custom Polo Shirt',
            'slug' => 'custom-polo-shirt',
            'product_category_id' => $category->id,
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Branded Apparel');
    }

    public function test_homepage_hides_empty_product_categories(): void
    {
        ProductCategory::create(['name' => 'Empty Category']);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertDontSee('Empty Category');
    }

    public function test_homepage_does_not_display_prices(): void
    {
        $category = ProductCategory::create(['name' => 'Apparel']);

        Product::create([
            'name' => 'Premium Branded Hoodie',
            'slug' => 'premium-branded-hoodie',
            'price' => 2500,
            'product_category_id' => $category->id,
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertDontSee('KSh');
        $response->assertDontSee('2,500');
    }
}
