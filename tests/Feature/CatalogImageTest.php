<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class CatalogImageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Reproduce a deployment that still has the development storage URLs cached.
        config([
            'filesystems.disks.uploads.url' => 'http://127.0.0.1:8000/uploads',
            'filesystems.disks.public.url' => 'http://127.0.0.1:8000/storage',
        ]);
        Storage::fake('uploads', ['url' => config('filesystems.disks.uploads.url')]);
        Storage::fake('public', ['url' => config('filesystems.disks.public.url')]);
    }

    public function test_category_product_and_gallery_images_use_the_current_https_site(): void
    {
        foreach (['categories/apparel.jpg', 'products/polo.jpg', 'products/polo-back.jpg'] as $path) {
            Storage::disk('uploads')->put($path, 'image');
        }

        $category = ProductCategory::create([
            'name' => 'Apparel',
            'image_path' => 'categories/apparel.jpg',
        ]);
        $product = Product::create([
            'name' => 'Branded Polo',
            'slug' => 'branded-polo',
            'product_category_id' => $category->id,
            'image_path' => 'products/polo.jpg',
            'is_active' => true,
        ]);
        $product->images()->create(['image_path' => 'products/polo-back.jpg']);

        $this->get('https://catalog.example/')
            ->assertOk()
            ->assertSee('src="https://catalog.example/uploads/categories/apparel.jpg"', false)
            ->assertSee('src="https://catalog.example/uploads/products/polo.jpg"', false)
            ->assertDontSee('http://127.0.0.1:8000/uploads');

        $this->get('https://catalog.example/products?category=apparel')
            ->assertOk()
            ->assertSee('src="https://catalog.example/uploads/products/polo.jpg"', false)
            ->assertDontSee('products/polo-back.jpg');

        $this->get('https://catalog.example/products/branded-polo')
            ->assertOk()
            ->assertSee('src="https://catalog.example/uploads/products/polo.jpg"', false)
            ->assertSee('src="https://catalog.example/uploads/products/polo-back.jpg"', false)
            ->assertDontSee('http://127.0.0.1:8000/uploads');
    }

    public function test_product_cards_use_the_first_available_gallery_photo_when_the_main_photo_is_missing(): void
    {
        Storage::disk('uploads')->put('products/cap-front.jpg', 'front');
        Storage::disk('uploads')->put('products/cap-back.jpg', 'back');

        $category = ProductCategory::create(['name' => 'Headwear']);
        $product = Product::create([
            'name' => 'Branded Cap',
            'slug' => 'branded-cap',
            'product_category_id' => $category->id,
            'image_path' => 'products/missing-main.jpg',
            'is_active' => true,
        ]);
        $product->images()->create(['image_path' => 'products/cap-back.jpg', 'sort_order' => 2]);
        $product->images()->create(['image_path' => 'products/missing-gallery.jpg', 'sort_order' => 0]);
        $product->images()->create(['image_path' => 'products/cap-front.jpg', 'sort_order' => 1]);

        $this->get('https://catalog.example/products?category=headwear')
            ->assertOk()
            ->assertSee('src="https://catalog.example/uploads/products/cap-front.jpg"', false)
            ->assertDontSee('products/cap-back.jpg')
            ->assertDontSee('aurix-branding-collage.png');

        $homepage = $this->get('https://catalog.example/')->assertOk();
        $featured = Str::betweenFirst($homepage->getContent(), '<section class="taf-section taf-home-products">', '</section>');
        $this->assertStringContainsString('src="https://catalog.example/uploads/products/cap-front.jpg"', $featured);
        $this->assertStringNotContainsString('aurix-branding-collage.png', $featured);

        Product::create([
            'name' => 'Related Hat',
            'slug' => 'related-hat',
            'product_category_id' => $category->id,
            'is_active' => true,
        ]);
        $this->get('https://catalog.example/products/related-hat')
            ->assertOk()
            ->assertSee('src="https://catalog.example/uploads/products/cap-front.jpg"', false);
    }

    public function test_legacy_public_images_are_copied_to_uploads_and_use_the_current_site(): void
    {
        Storage::disk('public')->put('categories/print.jpg', 'category image');
        Storage::disk('public')->put('products/cards.jpg', 'product image');
        $category = ProductCategory::create([
            'name' => 'Print',
            'image_path' => 'categories/print.jpg',
        ]);
        Product::create([
            'name' => 'Business Cards',
            'slug' => 'business-cards',
            'product_category_id' => $category->id,
            'image_path' => 'products/cards.jpg',
            'is_active' => true,
        ]);

        $this->get('https://catalog.example/')
            ->assertOk()
            ->assertSee('src="https://catalog.example/uploads/categories/print.jpg"', false)
            ->assertSee('src="https://catalog.example/uploads/products/cards.jpg"', false);

        $this->assertSame('category image', Storage::disk('uploads')->get('categories/print.jpg'));
        $this->assertSame('product image', Storage::disk('uploads')->get('products/cards.jpg'));
    }

    public function test_products_without_any_available_photo_keep_the_fallback(): void
    {
        $product = Product::create([
            'name' => 'Missing Photo',
            'slug' => 'missing-photo',
            'image_path' => 'products/missing.jpg',
            'is_active' => true,
        ]);
        $product->images()->create(['image_path' => 'products/missing-gallery.jpg']);

        $this->get('https://catalog.example/products')
            ->assertOk()
            ->assertSee('src="https://catalog.example/images/aurix-branding-collage.png"', false)
            ->assertDontSee('uploads/products/missing');
    }

    public function test_admin_shows_saved_paths_when_image_files_are_unavailable(): void
    {
        $product = Product::create([
            'name' => 'Official Corporate Letterheads',
            'slug' => 'official-corporate-letterheads',
            'image_path' => 'products/missing-letterhead.webp',
            'is_active' => true,
        ]);
        $product->images()->create(['image_path' => 'products/missing-gallery.webp']);

        $this->actingAs(User::factory()->create())
            ->get('/admin/products/'.$product->id.'/edit')
            ->assertOk()
            ->assertSee('This saved image is unavailable.')
            ->assertSee('products/missing-letterhead.webp')
            ->assertSee('products/missing-gallery.webp')
            ->assertDontSee('<img src=""', false);
    }
}
