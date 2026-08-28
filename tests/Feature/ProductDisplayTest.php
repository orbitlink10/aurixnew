<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductDisplayTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_index_cards_show_name_category_and_quote_without_pricing(): void
    {
        Storage::fake('uploads');
        Storage::disk('uploads')->put('products/cap.jpg', 'image');

        Product::create([
            'name' => 'Custom Caps, Hats, and Beanies',
            'slug' => 'custom-caps-hats-and-beanies',
            'price' => 200,
            'quantity' => 5,
            'category_name' => 'Corporate Apparel & Uniforms',
            'subcategory_name' => 'Casual & Event Teamwear Printing',
            'image_path' => 'products/cap.jpg',
            'is_active' => true,
        ]);

        $response = $this->get('/products');

        $response->assertOk();
        $response->assertSee('Custom Caps, Hats, and Beanies');
        $response->assertSee('Corporate Apparel & Uniforms');
        $response->assertSee('Request Quote');
        $response->assertDontSee('KSh 200');
        $response->assertDontSee('Star 4.8');
        $response->assertDontSee('Add to Cart');
    }

    public function test_product_detail_uses_uploaded_gallery_images_for_thumbnails(): void
    {
        Storage::fake('uploads');
        Storage::disk('uploads')->put('products/letterhead-main.jpg', 'image');
        Storage::disk('uploads')->put('products/letterhead-side.jpg', 'image');
        Storage::disk('uploads')->put('products/letterhead-close.jpg', 'image');

        $product = Product::create([
            'name' => 'Official Corporate Letterheads',
            'slug' => 'official-corporate-letterheads',
            'price' => 100,
            'image_path' => 'products/letterhead-main.jpg',
            'is_active' => true,
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => 'products/letterhead-side.jpg',
            'sort_order' => 1,
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => 'products/letterhead-close.jpg',
            'sort_order' => 2,
        ]);

        $response = $this->get('/products/official-corporate-letterheads');

        $response->assertOk();
        $response->assertSee('id="productMainImage"', false);
        $response->assertSee('data-gallery-thumb', false);
        $response->assertSee('products/letterhead-main.jpg');
        $response->assertSee('products/letterhead-side.jpg');
        $response->assertSee('products/letterhead-close.jpg');
    }

    public function test_product_detail_does_not_display_prices(): void
    {
        Storage::fake('uploads');

        Product::create([
            'name' => 'Custom T-Shirt',
            'slug' => 'custom-t-shirt',
            'price' => 850,
            'marked_price' => 1200,
            'quantity' => 10,
            'is_active' => true,
        ]);

        $response = $this->get('/products/custom-t-shirt');

        $response->assertOk();
        $response->assertDontSee('KSh');
        $response->assertDontSee('850');
        $response->assertDontSee('Starting at');
        $response->assertSee('Request a Quote');
    }
}
