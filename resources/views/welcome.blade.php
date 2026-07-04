<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Aurix Branding</title>
        <meta name="description" content="Aurix Branding provides custom apparel, promotional products, signage, and branded print materials with nationwide delivery.">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="preconnect" href="https://naiprinters.co.ke" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="icon" href="{{ asset('images/aurix-mark.svg') }}" type="image/svg+xml">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="taf-page">
        @php
            $assetBase = 'https://naiprinters.co.ke';
            $fallbackCategories = [
                ['name' => 'Caps', 'image' => '/storage/media-library/vcwO607a80yVPosKoaJDe8TTghzXiidTi71bZcKR.jpg'],
                ['name' => 'T-Shirts', 'image' => '/storage/media-library/gPxJcSfQyNq800mYR7L9ShbOa9v14tFT9EllYXfN.jpg'],
                ['name' => 'Bags', 'image' => '/storage/media-library/blAadlyvjfYisJc7kTbQ3KaKGe4mNx5utdFy0NJQ.png'],
                ['name' => 'Banners', 'image' => '/storage/media-library/DnFPnNQR1k6VMcpEpywCvt3BFzmAwbEnax0ywKop.jpg'],
                ['name' => 'Business Cards', 'image' => '/storage/media-library/om47dlzLTyw1w5x6zYITYxOkLyUImobXJDdKQYyL.jpg'],
                ['name' => 'Brochures', 'image' => '/storage/media-library/WTWxzKuUU0eJbzVWCMJgthfA3cSs7EQ8jtpazyj4.png'],
            ];
            $homepageCategories = isset($workCategories) && $workCategories->count()
                ? $workCategories->map(fn ($category) => [
                    'name' => $category->name,
                    'image' => $category->image_url ?: asset('images/hero-showcase.svg'),
                    'item_count' => $category->item_count,
                    'is_custom' => true,
                ])->values()->all()
                : array_map(fn ($category) => $category + ['item_count' => null, 'is_custom' => false], $fallbackCategories);
            $homepageHeroImages = isset($heroImageUrls) && count($heroImageUrls)
                ? array_values($heroImageUrls)
                : [
                    $assetBase.'/storage/media-library/vcwO607a80yVPosKoaJDe8TTghzXiidTi71bZcKR.jpg',
                    $assetBase.'/storage/media-library/gPxJcSfQyNq800mYR7L9ShbOa9v14tFT9EllYXfN.jpg',
                    $assetBase.'/storage/media-library/CsoceV7QRBwRhuWCHHEiM8qm845tbT4YLmjrguSE.png',
                ];
            $serviceHighlights = [
                ['title' => 'Heat Transfer', 'copy' => 'Sharp full-color apparel prints for events, teams, and staff uniforms.'],
                ['title' => 'Embroidery', 'copy' => 'Premium stitched logos for polos, caps, hoodies, jackets, and bags.'],
                ['title' => 'Laser Etching', 'copy' => 'Clean permanent branding for tumblers, awards, plaques, and gifts.'],
                ['title' => 'Large Format', 'copy' => 'Banners, backdrops, wall graphics, vehicle stickers, and shop signage.'],
            ];
            $featuredProducts = [
                ['cat' => 'Promotional Items', 'name' => 'Branded Lanyards', 'price' => '450', 'image' => '/storage/product-thumbnails/RB22IMcehGJedRgMrsuo8lzCbXuoCGJs7akE1NQn.png'],
                ['cat' => 'Apparel', 'name' => 'Custom Hoodies', 'price' => '2,800', 'image' => '/storage/media-library/gPxJcSfQyNq800mYR7L9ShbOa9v14tFT9EllYXfN.jpg'],
                ['cat' => 'Print', 'name' => 'Business Cards', 'price' => '10', 'image' => '/storage/product-thumbnails/GLhAqU3GevIf2xpwSMaLB1tsLmZxYLO2eyVI2lvS.jpg'],
                ['cat' => 'Displays', 'name' => 'Rollup Banners', 'price' => '8,700', 'image' => '/storage/product-thumbnails/qV1hP9lRiIeXcN8Bu9tagqfUTf8RuBY59LjUXjgg.jpg'],
            ];
        @endphp

        <div class="taf-topbar">
            <div class="taf-wrap">
                <span>Since 2019</span>
                <span>Custom apparel, promo items, signage, and print</span>
                <span>Same-day support for urgent jobs</span>
            </div>
        </div>

        <header class="taf-header">
            <div class="taf-wrap taf-header-main">
                <a href="{{ url('/') }}" class="taf-brand" aria-label="Aurix Branding home">
                    <img src="{{ asset('images/aurix-mark.svg') }}" alt="">
                    <span>Aurix Branding</span>
                </a>
                <form class="taf-search" action="{{ route('public.products.index') }}" method="get">
                    <input name="q" type="search" placeholder="Search apparel, branding, signage">
                    <button type="submit" aria-label="Search">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 6 16.65a7.5 7.5 0 0 0 10.65 0Z"/></svg>
                    </button>
                </form>
                <div class="taf-phone">
                    <span>For support call</span>
                    <strong>+254 745 506 619</strong>
                </div>
            </div>
            <nav class="taf-nav" aria-label="Product categories">
                <div class="taf-wrap">
                    @foreach(['Women', 'Men', 'Outerwear', 'Headwear', 'Uniforms', 'Youth', 'Gifts', 'Infant & Toddler', 'Brands'] as $item)
                        <a href="{{ route('public.products.index', ['q' => $item]) }}">{{ $item }}</a>
                    @endforeach
                </div>
            </nav>
        </header>

        <main>
            <section class="taf-hero">
                <div class="taf-wrap taf-hero-grid">
                    <div class="taf-hero-copy">
                        <span class="taf-eyebrow">Custom branding made simple</span>
                        <h1>We offer 100% customized branding and embroidery services</h1>
                        <p>Build branded apparel, promotional products, signage, and business materials with design help, reliable production, and nationwide delivery.</p>
                        <div class="taf-hero-actions">
                            <a href="{{ route('public.products.index') }}" class="taf-primary-btn">Browse Products</a>
                            <a href="https://wa.me/254745506619?text=Hello%20Aurix%20Branding%2C%20I%20need%20a%20quote." class="taf-link-btn">Request Quote</a>
                        </div>
                        <div class="taf-callout">
                            <span>Or call us at</span>
                            <strong>+254 745 506 619</strong>
                        </div>
                    </div>
                    <div class="taf-hero-visual" style="--hero-slide-count: {{ count($homepageHeroImages) }};">
                        <div class="taf-hero-badge">100% custom</div>
                        @foreach($homepageHeroImages as $index => $heroImageUrl)
                            <img
                                src="{{ $heroImageUrl }}"
                                alt=""
                                style="--hero-slide-index: {{ $index }};"
                                @class(['is-active' => $index === 0])
                            >
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="taf-section">
                <div class="taf-wrap">
                    <div class="taf-section-head centered">
                        <h2>Shop Promotional Products</h2>
                        <p>Choose popular products and order your customized branding.</p>
                    </div>
                    <div class="taf-category-row">
                        @foreach($homepageCategories as $category)
                            <a href="{{ route('public.products.index', ['q' => $category['name']]) }}" class="taf-category-card">
                                <span class="taf-category-media">
                                    <img src="{{ $category['is_custom'] ? $category['image'] : $assetBase.$category['image'] }}" alt="{{ $category['name'] }}">
                                </span>
                                <strong>{{ $category['name'] }}</strong>
                                @if($category['item_count'])
                                    <small>{{ $category['item_count'] }} {{ $category['item_count'] == 1 ? 'item' : 'items' }}</small>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="taf-section taf-services">
                <div class="taf-wrap">
                    <div class="taf-section-head">
                        <div>
                            <span class="taf-eyebrow">Services</span>
                            <h2>Decoration methods for every brand surface</h2>
                        </div>
                        <a href="{{ route('public.products.index') }}">View all products</a>
                    </div>
                    <div class="taf-service-grid">
                        @foreach($serviceHighlights as $service)
                            <article class="taf-service-card">
                                <span></span>
                                <h3>{{ $service['title'] }}</h3>
                                <p>{{ $service['copy'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="taf-section">
                <div class="taf-wrap taf-split">
                    <div class="taf-custom-card">
                        <img src="{{ $assetBase }}/storage/media-library/gPxJcSfQyNq800mYR7L9ShbOa9v14tFT9EllYXfN.jpg" alt="Custom apparel">
                    </div>
                    <div class="taf-split-copy">
                        <span class="taf-eyebrow">Apparel customization</span>
                        <h2>Bring your logo to uniforms, caps, hoodies, bags, and staff kits</h2>
                        <p>Pick the product, share your artwork, and our team will guide the right print, embroidery, or finishing method for the job.</p>
                        <div class="taf-brand-strip">
                            <span>Nike</span>
                            <span>Gildan</span>
                            <span>Fruit of the Loom</span>
                            <span>Custom</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="taf-section">
                <div class="taf-wrap">
                    <div class="taf-section-head">
                        <div>
                            <span class="taf-eyebrow">Popular picks</span>
                            <h2>Ready-to-brand products</h2>
                        </div>
                        <a href="{{ route('public.products.index') }}">All products</a>
                    </div>
                    <div class="taf-product-grid">
                        @foreach($featuredProducts as $product)
                            <a href="{{ route('public.products.index', ['q' => $product['name']]) }}" class="taf-product-card">
                                <img src="{{ $assetBase }}{{ $product['image'] }}" alt="{{ $product['name'] }}">
                                <span>{{ $product['cat'] }}</span>
                                <h3>{{ $product['name'] }}</h3>
                                <p>From KES {{ $product['price'] }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="taf-testimonial">
                <div class="taf-wrap taf-testimonial-grid">
                    <div>
                        <span class="taf-eyebrow">Trusted production partner</span>
                        <h2>Fast support for teams, campaigns, events, and retail brands.</h2>
                    </div>
                    <blockquote>
                        "Aurix helps us move from artwork to branded merchandise quickly. The team is practical, responsive, and consistent on quality."
                        <cite>Procurement Lead, Nairobi</cite>
                    </blockquote>
                </div>
            </section>
        </main>

        <footer class="taf-footer">
            <div class="taf-wrap taf-footer-grid">
                <div>
                    <h3>Aurix Branding</h3>
                    <p>Custom apparel, promotional products, print, and signage for brands that need dependable production.</p>
                </div>
                <div>
                    <h4>Shop</h4>
                    <a href="{{ route('public.products.index') }}">All Products</a>
                    <a href="{{ route('public.products.index', ['q' => 'Apparel']) }}">Apparel</a>
                    <a href="{{ route('public.products.index', ['q' => 'Banners']) }}">Banners</a>
                </div>
                <div>
                    <h4>Support</h4>
                    <a href="https://wa.me/254745506619?text=Hello%20Aurix%20Branding%2C%20I%20need%20a%20quote.">WhatsApp Quote</a>
                    <a href="{{ url('/login') }}">Client Login</a>
                    <a href="{{ url('/') }}">Home</a>
                </div>
                <form class="taf-newsletter" action="{{ route('public.products.index') }}" method="get">
                    <h4>Find products faster</h4>
                    <div>
                        <input name="q" placeholder="Search products">
                        <button type="submit">Search</button>
                    </div>
                </form>
            </div>
        </footer>
    </body>
</html>
