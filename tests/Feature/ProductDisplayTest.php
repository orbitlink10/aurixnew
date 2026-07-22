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

    public function test_products_index_cards_only_show_image_and_product_name(): void
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
        $response->assertSee('object-fit: contain', false);
        $response->assertDontSee('Corporate Apparel & Uniforms');
        $response->assertDontSee('Casual & Event Teamwear Printing');
        $response->assertDontSee('KSh 200');
        $response->assertDontSee('Star 4.8');
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
}
