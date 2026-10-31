<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [];

        $static = [
            ['url' => url('/'), 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['url' => route('public.services'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => route('public.corporate-branding'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => route('public.portfolio'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => route('public.about'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => route('public.contact'), 'priority' => '0.7', 'changefreq' => 'yearly'],
            ['url' => route('public.embroidery'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => route('public.products.index'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => route('public.quote'), 'priority' => '0.5', 'changefreq' => 'yearly'],
        ];

        foreach ($static as $entry) {
            $urls[] = $this->buildUrl(
                $entry['url'],
                null,
                $entry['priority'],
                $entry['changefreq']
            );
        }

        if (Schema::hasTable('products')) {
            $products = Product::query()
                ->where('is_active', true)
                ->get(['slug', 'updated_at']);

            foreach ($products as $product) {
                $urls[] = $this->buildUrl(
                    route('public.products.show', ['product' => $product->slug]),
                    $product->updated_at,
                    '0.7',
                    'monthly'
                );
            }
        }

        if (Schema::hasTable('blog_posts')) {
            $posts = BlogPost::query()
                ->where('status', 'published')
                ->get(['slug', 'updated_at']);

            foreach ($posts as $post) {
                $urls[] = $this->buildUrl(
                    route('public.blog.show', ['slug' => $post->slug]),
                    $post->updated_at,
                    '0.6',
                    'monthly'
                );
            }
        }

        $xml = view('sitemap', ['urls' => $urls])->render();

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    private function buildUrl(string $url, $lastmod, string $priority, string $changefreq): array
    {
        return [
            'url' => $url,
            'lastmod' => $lastmod instanceof \DateTimeInterface
                ? $lastmod->format('c')
                : ($lastmod ? date('c', strtotime((string) $lastmod)) : null),
            'priority' => $priority,
            'changefreq' => $changefreq,
        ];
    }
}
