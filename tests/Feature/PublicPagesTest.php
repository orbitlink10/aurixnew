<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_business_pages_return_200_with_unique_h1(): void
    {
        $pages = [
            '/services' => 'Branding &amp; Printing Services in Nairobi, Kenya',
            '/corporate-branding' => 'Corporate Branding in Nairobi, Kenya',
            '/about' => 'About Aurix Branding',
            '/contact' => 'Contact Aurix Branding',
            '/portfolio' => 'Our Work &amp; Portfolio',
        ];

        foreach ($pages as $url => $h1) {
            $response = $this->get($url);
            $response->assertOk();
            $response->assertSee('<h1', false);
            $response->assertSee($h1, false);
        }
    }

    public function test_missing_pages_return_404_not_homepage(): void
    {
        $response = $this->get('/this-page-does-not-exist');
        $response->assertNotFound();
    }

    public function test_sitemap_xml_returns_valid_content(): void
    {
        Product::create([
            'name' => 'Branded T-Shirt',
            'slug' => 'branded-t-shirt',
            'is_active' => true,
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $response->assertSee('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', false);
        $response->assertSee(url('/products/branded-t-shirt'), false);
        $response->assertSee(route('public.services'), false);
        $response->assertDontSee('/admin', false);
    }

    public function test_search_results_are_noindexed(): void
    {
        $response = $this->get('/products?q=tshirt');

        $response->assertOk();
        $response->assertSee('noindex, follow', false);
    }

    public function test_robots_txt_declares_sitemap(): void
    {
        $content = file_get_contents(public_path('robots.txt'));

        $this->assertStringContainsString('Sitemap:', $content);
        $this->assertStringContainsString('sitemap.xml', $content);
    }
}
