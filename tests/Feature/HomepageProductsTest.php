<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\WorkCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class HomepageProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_uses_uploaded_work_when_no_product_photos_are_available(): void
    {
        Storage::fake('uploads');
        Storage::disk('uploads')->put('work-categories/corporate-uniforms.jpg', 'image');

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
        $response->assertSee(Storage::disk('uploads')->url('work-categories/corporate-uniforms.jpg'));
    }

    public function test_recent_projects_use_active_products_and_their_saved_photos(): void
    {
        Storage::fake('uploads');
        Storage::fake('public');
        foreach (['pen.jpg', 'badge.jpg', 'badge-alternate.jpg', 'old-work.jpg'] as $file) {
            Storage::disk('uploads')->put('products/'.$file, 'image');
        }

        $pen = Product::create([
            'name' => 'Branded Pen',
            'slug' => 'branded-pen',
            'is_active' => true,
        ]);
        $pen->images()->create(['image_path' => 'products/missing-gallery.jpg', 'sort_order' => 0]);
        $pen->images()->create(['image_path' => 'products/pen.jpg', 'sort_order' => 1]);

        $badge = Product::create([
            'name' => 'Employee Badge',
            'slug' => 'employee-badge',
            'image_path' => 'products/badge.jpg',
            'is_active' => true,
        ]);
        $badge->images()->create(['image_path' => 'products/badge-alternate.jpg', 'sort_order' => 0]);

        Product::create([
            'name' => 'Unpublished Product',
            'slug' => 'unpublished-product',
            'image_path' => 'products/badge.jpg',
            'is_active' => false,
        ]);
        Product::create([
            'name' => 'Missing Photo',
            'slug' => 'missing-photo',
            'image_path' => 'products/missing.jpg',
            'is_active' => true,
        ]);
        WorkCategory::create([
            'name' => 'Old Work',
            'image_path' => 'products/old-work.jpg',
            'is_active' => true,
        ]);

        $response = $this->get('/')->assertOk();
        $section = Str::betweenFirst($response->getContent(), '<section id="work"', '</section>');

        $this->assertSame(2, substr_count($section, 'class="taf-work-card"'));
        $this->assertStringContainsString('Employee Badge', $section);
        $this->assertStringContainsString('Branded Pen', $section);
        $this->assertStringContainsString('src="'.asset('uploads/products/badge.jpg').'"', $section);
        $this->assertStringContainsString('src="'.asset('uploads/products/pen.jpg').'"', $section);
        $this->assertStringContainsString('href="'.route('public.products.show', $pen->slug).'"', $section);
        $this->assertLessThan(strpos($section, 'Branded Pen'), strpos($section, 'Employee Badge'));
        $this->assertStringNotContainsString('badge-alternate.jpg', $section);
        $this->assertStringNotContainsString('Unpublished Product', $section);
        $this->assertStringNotContainsString('Missing Photo', $section);
        $this->assertStringNotContainsString('Old Work', $section);
        $this->assertStringNotContainsString('aurix-branding-collage.png', $section);
    }

    public function test_recent_projects_do_not_invent_cards_when_saved_images_are_missing(): void
    {
        Storage::fake('uploads');
        Storage::fake('public');
        WorkCategory::create([
            'name' => 'Missing Work Photo',
            'image_path' => 'works/missing.jpg',
            'is_active' => true,
        ]);

        $response = $this->get('/')->assertOk();
        $section = Str::betweenFirst($response->getContent(), '<section id="work"', '</section>');

        $this->assertStringContainsString('Recent branding projects will be added soon.', $section);
        $this->assertStringNotContainsString('<img', $section);
        $this->assertStringNotContainsString('Missing Work Photo', $section);
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
