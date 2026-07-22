<?php

namespace Tests\Feature;

use App\Models\Product;
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
}
