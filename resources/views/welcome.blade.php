<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Aurix Branding</title>
        <meta name="description" content="Aurix Branding provides custom apparel, promotional products, signage, and branded print materials with nationwide delivery.">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="preconnect" href="https://aurixbranding.co.ke" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="icon" href="{{ asset('images/aurix-branding-logo.png') }}" type="image/png">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="taf-page">
        @php
            $liveAssetBase = 'https://aurixbranding.co.ke';
            $homepageCategoryRecords = isset($homepageCategories) ? collect($homepageCategories) : collect();
            if ($homepageCategoryRecords->isEmpty() && isset($homepageSubCategories)) {
                $homepageCategoryRecords = collect($homepageSubCategories);
            }
            $homepageCategories = $homepageCategoryRecords->count()
                ? $homepageCategoryRecords->map(fn ($category) => [
                    'name' => $category->name,
                    'image' => $category->image_url ?: asset('images/aurix-design-categories.png'),
                    'item_count' => $category->item_count ?? $category->products_count ?? null,
                    'href' => route('public.products.index', ['category' => $category->slug ?? \Illuminate\Support\Str::slug($category->name)]),
                ])->values()->all()
                : [];
            $homepageHeroImages = isset($heroImageUrls) && count($heroImageUrls)
                ? array_values($heroImageUrls)
                : [
                    $liveAssetBase.'/uploads/hero/qhBf5eBt8xpbCtaN8SGflOm6LCouCvo4tqJg8u5e.png',
                    $liveAssetBase.'/uploads/hero/OFiWAkVafxQUbhec4573lMmWWBmBXQmymtI4xvUl.png',
                    $liveAssetBase.'/uploads/hero/DHQxJoDAHuZV1tQO9UATP8wrE6EYhW2HdeDyDJ27.png',
                    $liveAssetBase.'/uploads/hero/eD51M2yJAWvr4Nwq9iUCBneEHgcgMmw2IRsRzf8S.png',
                    $liveAssetBase.'/uploads/hero/9Q85zFlSCcrIuGxinlAFvcYG9QPvGwHV175BCOxg.jpg',
                ];
            $contact = $contactSettings ?? \App\Models\SiteSetting::defaultContactSettings();
            $whatsappPhone = '254700816670';
            $whatsappUrl = 'https://wa.me/'.$whatsappPhone.'?text='.rawurlencode($contact['whatsapp_message']);
            $phone = $contact['phone'] ?: '+254 700816670';
            $quoteUrl = $whatsappUrl;
            $tickerText = 'Premium Branding Solutions - Custom T-Shirts - Corporate Gifts - Vehicle Branding - Signage & Roll-Up Banners - Business Cards - Logo Design - High-Quality Printing - Same-Day Printing Available - Nationwide Delivery - Free Quotes';
            $homepageProductRecords = isset($homepageProducts) ? collect($homepageProducts) : collect();
            if ($homepageProductRecords->isEmpty() && \Illuminate\Support\Facades\Schema::hasTable('products')) {
                $homepageProductRecords = \App\Models\Product::with('category')->orderByDesc('updated_at')->take(8)->get();
            }
            $homepageProductCards = $homepageProductRecords->count()
                ? $homepageProductRecords->map(fn ($product) => [
                    'cat' => $product->category?->name ?: $product->category_name ?: 'Product',
                    'name' => $product->name,
                    'price' => (float) $product->price,
                    'marked_price' => $product->marked_price ? (float) $product->marked_price : null,
                    'image' => $product->image_url ?: asset('images/aurix-branding-collage.png'),
                    'href' => route('public.products.show', ['product' => $product->slug]),
                ])->values()->all()
                : [];
        @endphp

        <div class="taf-marquee" aria-label="Aurix branding services">
            <div class="taf-marquee-track">
                @foreach(range(1, 2) as $repeat)
                    <span>{{ $tickerText }}</span>
                @endforeach
            </div>
        </div>

        <header class="taf-header">
            <div class="taf-wrap taf-header-main">
                <a href="{{ url('/') }}" class="taf-brand" aria-label="Aurix Branding home">
                    <img src="{{ $logoUrl ?: asset('images/aurix-branding-logo.png') }}" alt="Aurix Branding logo">
                    <span>Aurix Branding</span>
                </a>
                <form class="taf-search" action="{{ route('public.products.index') }}" method="get">
                    <input name="q" type="search" placeholder="Search apparel, branding, signage">
                    <button type="submit" aria-label="Search">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 6 16.65a7.5 7.5 0 0 0 10.65 0Z"/></svg>
                    </button>
                </form>
                <div class="taf-phone">
                    <span>{{ $contact['support_label'] }}</span>
                    <strong>{{ $contact['phone'] }}</strong>
                </div>
            </div>
            <nav class="taf-nav" aria-label="Product categories">
                <div class="taf-wrap">
                    @include('partials.public-main-menu')
                </div>
            </nav>
        </header>

        <main>
            <section class="taf-hero">
                <div class="taf-wrap taf-hero-grid">
                    <div class="taf-hero-copy">
                        <span class="taf-eyebrow">Custom branding made simple</span>
                        <h1>We offer <span class="taf-pop-word">100%</span> customized branding and embroidery services</h1>
                        <p>Build branded apparel, promotional products, signage, and business materials with design help, reliable production, and nationwide delivery.</p>
                        <div class="taf-hero-actions">
                            <a href="{{ route('public.products.index') }}" class="taf-primary-btn">Browse Products</a>
                            <a href="{{ $whatsappUrl }}" class="taf-link-btn">Request Quote</a>
                        </div>
                        <div class="taf-callout">
                            <span>Or call us at</span>
                            <strong>{{ $contact['phone'] }}</strong>
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

            <section class="taf-section taf-category-section">
                <div class="taf-wrap">
                    <div class="taf-category-head">
                        <div>
                            <span class="taf-category-kicker">Shop by category</span>
                            <h2>Design categories</h2>
                        </div>
                        <a href="{{ route('public.products.index') }}">View all categories <span aria-hidden="true">&#8599;</span></a>
                    </div>
                    <div class="taf-category-row">
                        @forelse($homepageCategories as $category)
                            <a href="{{ $category['href'] }}" class="taf-category-card">
                                <span class="taf-category-media">
                                    <img src="{{ $category['image'] }}" alt="{{ $category['name'] }}">
                                </span>
                                <strong>{{ $category['name'] }}</strong>
                                <small>
                                    @if($category['item_count'] !== null)
                                        {{ $category['item_count'] }} {{ $category['item_count'] == 1 ? 'item' : 'items' }}
                                    @else
                                        Custom orders
                                    @endif
                                </small>
                            </a>
                        @empty
                            <p class="taf-dashboard-empty">No dashboard categories have been added yet.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <section class="taf-section taf-home-products">
                <div class="taf-wrap">
                    <div class="taf-product-section-head">
                        <div>
                            <span>Featured prints</span>
                            <h2>Best sellers right now</h2>
                        </div>
                        <p>Weekly drops <span></span> Limited runs</p>
                    </div>

                    <div class="taf-product-grid">
                        @forelse($homepageProductCards as $product)
                            @php
                                $price = (float) $product['price'];
                                $markedPrice = (float) ($product['marked_price'] ?? 0);
                                $discount = $markedPrice > $price && $markedPrice > 0
                                    ? max(1, round((($markedPrice - $price) / $markedPrice) * 100))
                                    : null;
                            @endphp
                            <a href="{{ $product['href'] }}" class="taf-product-card">
                                <span class="taf-product-media">
                                    @if($discount)
                                        <span class="taf-product-discount">-{{ $discount }}%</span>
                                    @endif
                                    <span class="taf-product-tools" aria-hidden="true">
                                        <span>&#9825;</span>
                                        <span>&#8645;</span>
                                    </span>
                                    @if($product['image'])
                                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
                                    @else
                                        <span class="taf-product-placeholder">No image</span>
                                    @endif
                                    <span class="taf-customize-btn">Customize Now</span>
                                </span>
                                <span class="taf-product-info">
                                    <small>{{ $product['cat'] }}</small>
                                    <strong>{{ $product['name'] }}</strong>
                                    <span class="taf-product-price">
                                        KSh {{ number_format($price, 0) }}
                                        @if($markedPrice > $price)
                                            <del>KSh {{ number_format($markedPrice, 0) }}</del>
                                        @endif
                                    </span>
                                    <span class="taf-color-dots" aria-hidden="true">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </span>
                                </span>
                            </a>
                        @empty
                            <p class="taf-dashboard-empty">No dashboard products have been added yet.</p>
                        @endforelse
                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer">
            <section class="footer-main">
                <div class="footer-container">
                    <div class="footer-grid">
                        <div>
                            <h2 class="footer-title">CONTACT US</h2>
                            <a class="footer-brand" href="{{ url('/') }}"><img src="{{ asset('images/aurix-branding-logo.png') }}" alt="Aurix Branding logo"></a>
                            <ul class="footer-contact">
                                <li><span class="footer-icon">&#8250;</span><span>{{ $phone }}</span></li>
                                @if(!empty($contact['email']))
                                    <li><span class="footer-icon">&#8250;</span><span>{{ $contact['email'] }}</span></li>
                                @endif
                                <li><span class="footer-icon">&#8250;</span><span>Mon-Fri: 8am - 5pm</span></li>
                                <li><span class="footer-icon">&#8250;</span><span>Sat: 8am - 12pm</span></li>
                            </ul>
                        </div>
                        <div>
                            <h2 class="footer-title">Our Services</h2>
                            <ul class="footer-services">
                                <li><span class="footer-icon">&#8250;</span><a href="{{ url('/products') }}">Printed Products</a></li>
                                <li><span class="footer-icon">&#8250;</span><a href="{{ url('/#services') }}">Brand Strategy</a></li>
                                <li><span class="footer-icon">&#8250;</span><a href="{{ url('/#services') }}">Signage</a></li>
                                <li><span class="footer-icon">&#8250;</span><a href="{{ url('/#services') }}">Uniform Branding</a></li>
                                <li><span class="footer-icon">&#8250;</span><a href="{{ url('/#services') }}">Packaging</a></li>
                                <li><span class="footer-icon">&#8250;</span><a href="{{ $quoteUrl }}">Quote Request</a></li>
                                <li><span class="footer-icon">&#8250;</span><a href="{{ url('/products') }}">Branding Guides</a></li>
                                <li><span class="footer-icon">&#8250;</span><a href="{{ url('/') }}">Aurix Branding</a></li>
                            </ul>
                            <h2 class="footer-title">Our Office Address</h2>
                            <div class="footer-address"><span class="footer-icon">&#8250;</span><span>{{ $contact['address'] ?: 'Nairobi, Kenya. Branding and printing support available across Kenya.' }}</span></div>
                        </div>
                        <div>
                            <h2 class="footer-title">Find Us On Social Media</h2>
                            <div class="footer-social">
                                <a href="#" aria-label="Facebook">f</a>
                                <a href="#" aria-label="Twitter">x</a>
                                <a href="#" aria-label="Instagram">ig</a>
                                <a href="#" aria-label="LinkedIn">in</a>
                            </div>
                            <h2 class="footer-title">Signup To Our Newsletter</h2>
                            <form class="footer-newsletter" action="{{ url('/') }}" method="get">
                                <input type="email" name="email" placeholder="Email Address..." aria-label="Email Address">
                                <button type="submit">Subscribe!</button>
                            </form>
                        </div>
                    </div>
                    <div class="footer-copy">&copy; {{ now()->year }} Aurix Branding. Branding, printing, signage, uniforms, packaging, and promotional products across Kenya.</div>
                </div>
            </section>
        </footer>
        <a class="taf-whatsapp-float" href="{{ $whatsappUrl }}" target="_blank" rel="noopener" aria-label="Chat with Aurix Branding on WhatsApp">
            <svg viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                <path fill="currentColor" d="M16.02 3.2c-7.06 0-12.8 5.68-12.8 12.68 0 2.24.6 4.42 1.74 6.34L3.1 29l6.98-1.82a12.9 12.9 0 0 0 5.94 1.46c7.06 0 12.8-5.68 12.8-12.68S23.08 3.2 16.02 3.2Zm0 23.28c-1.9 0-3.76-.5-5.38-1.44l-.38-.22-4.14 1.08 1.1-4.02-.24-.42a10.35 10.35 0 0 1-1.6-5.58c0-5.8 4.78-10.52 10.64-10.52s10.64 4.72 10.64 10.52-4.78 10.6-10.64 10.6Zm5.82-7.88c-.32-.16-1.9-.94-2.2-1.04-.3-.12-.52-.16-.74.16-.22.32-.84 1.04-1.04 1.26-.18.22-.38.24-.7.08-.32-.16-1.36-.5-2.58-1.58-.96-.84-1.6-1.88-1.78-2.2-.18-.32-.02-.5.14-.66.14-.14.32-.38.48-.56.16-.18.22-.32.32-.54.1-.22.06-.4-.02-.56-.08-.16-.74-1.78-1.02-2.44-.26-.64-.54-.56-.74-.56h-.64c-.22 0-.56.08-.86.4-.3.32-1.14 1.1-1.14 2.68s1.18 3.12 1.34 3.34c.16.22 2.32 3.52 5.62 4.94.78.34 1.4.54 1.88.7.8.24 1.52.2 2.08.12.64-.1 1.9-.78 2.16-1.52.26-.74.26-1.38.18-1.52-.08-.14-.28-.22-.6-.38Z"/>
            </svg>
        </a>
    </body>
</html>
