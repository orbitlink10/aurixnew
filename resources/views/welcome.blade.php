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
            $fallbackCategories = [
                ['name' => 'T-Shirts', 'image' => asset('images/aurix-tshirt-category.png')],
                ['name' => 'Polo T-Shirts', 'image' => asset('images/aurix-polo-category.png')],
                ['name' => 'Hoodies', 'image' => asset('images/aurix-hoodie-category.png')],
                ['name' => 'Kids', 'image' => asset('images/aurix-kids-category.png')],
                ['name' => 'Business Cards', 'image' => asset('images/aurix-branding-collage.png')],
                ['name' => 'Brochures', 'image' => asset('images/aurix-branding-collage.png')],
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
                    $liveAssetBase.'/uploads/hero/qhBf5eBt8xpbCtaN8SGflOm6LCouCvo4tqJg8u5e.png',
                    $liveAssetBase.'/uploads/hero/OFiWAkVafxQUbhec4573lMmWWBmBXQmymtI4xvUl.png',
                    $liveAssetBase.'/uploads/hero/DHQxJoDAHuZV1tQO9UATP8wrE6EYhW2HdeDyDJ27.png',
                    $liveAssetBase.'/uploads/hero/eD51M2yJAWvr4Nwq9iUCBneEHgcgMmw2IRsRzf8S.png',
                    $liveAssetBase.'/uploads/hero/9Q85zFlSCcrIuGxinlAFvcYG9QPvGwHV175BCOxg.jpg',
            ];
            $contact = $contactSettings ?? \App\Models\SiteSetting::defaultContactSettings();
            $whatsappPhone = '254700816670';
            $whatsappUrl = 'https://wa.me/'.$whatsappPhone.'?text='.rawurlencode($contact['whatsapp_message']);
            $tickerText = '⭐ Premium Branding Solutions • 👕 Custom T-Shirts • 🎁 Corporate Gifts • 🚗 Vehicle Branding • 🪧 Signage & Roll-Up Banners • 📇 Business Cards • 🎨 Logo Design • 🖨️ High-Quality Printing • ⚡ Same-Day Printing Available • 🚚 Nationwide Delivery • 📞 Free Quotes';
            $serviceHighlights = [
                ['title' => 'Heat Transfer', 'copy' => 'Sharp full-color apparel prints for events, teams, and staff uniforms.'],
                ['title' => 'Embroidery', 'copy' => 'Premium stitched logos for polos, caps, hoodies, jackets, and bags.'],
                ['title' => 'Laser Etching', 'copy' => 'Clean permanent branding for tumblers, awards, plaques, and gifts.'],
                ['title' => 'Large Format', 'copy' => 'Banners, backdrops, wall graphics, vehicle stickers, and shop signage.'],
            ];
            $featuredProducts = [
                ['cat' => 'Apparel', 'name' => 'Custom T-Shirts', 'price' => '1,200', 'image' => asset('images/aurix-tshirt-category.png')],
                ['cat' => 'Apparel', 'name' => 'Custom Hoodies', 'price' => '2,800', 'image' => asset('images/aurix-hoodie-category.png')],
                ['cat' => 'Corporate', 'name' => 'Polo T-Shirts', 'price' => '1,800', 'image' => asset('images/aurix-polo-category.png')],
                ['cat' => 'Print', 'name' => 'Business Cards', 'price' => '10', 'image' => asset('images/aurix-branding-collage.png')],
            ];
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
                                    <img src="{{ $category['image'] }}" alt="{{ $category['name'] }}">
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

            <section class="taf-section taf-design-categories">
                <div class="taf-wrap">
                    <div class="taf-design-head">
                        <div>
                            <span class="taf-eyebrow">Shop by category</span>
                            <h2>Design categories</h2>
                        </div>
                        <a href="{{ route('public.products.index') }}">View all categories ↗</a>
                    </div>
                    <div class="taf-design-category-row">
                        @foreach([
                            ['name' => 'T-shirt', 'count' => '16 items', 'slug' => 't-shirt', 'pos' => '50% 50%', 'image' => 'images/aurix-tshirt-category.png'],
                            ['name' => 'Polo T-shirt', 'count' => '8 items', 'slug' => 'polo-t-shirt', 'pos' => '50% 50%', 'image' => 'images/aurix-polo-category.png'],
                            ['name' => 'Hoodie', 'count' => '9 items', 'slug' => 'hoodie', 'pos' => '50% 50%', 'image' => 'images/aurix-hoodie-category.png'],
                            ['name' => 'Kids', 'count' => '6 items', 'slug' => 'kids', 'pos' => '50% 50%', 'image' => 'images/aurix-kids-category.png'],
                            ['name' => 'Embroidery', 'count' => '5 items', 'slug' => 'embroidery', 'pos' => '50% 50%', 'image' => 'images/aurix-embroidery-production-collage.png'],
                            ['name' => 'Create Design', 'count' => 'Custom orders', 'slug' => 'create-design', 'pos' => '50% 50%', 'image' => 'images/aurix-branding-collage.png'],
                            ['name' => 'Corporate', 'count' => '12 items', 'slug' => 'corporate', 'pos' => '50% 50%', 'image' => 'images/aurix-branding-collage.png'],
                        ] as $category)
                            <a href="{{ $category['slug'] === 'embroidery' ? route('public.embroidery') : ($category['slug'] === 'create-design' ? route('public.create-design') : route('public.products.index', ['category' => $category['slug']])) }}" class="taf-design-category">
                                <span>
                                    <img src="{{ asset($category['image'] ?? 'images/aurix-design-categories.png') }}" alt="{{ $category['name'] }}" style="object-position: {{ $category['pos'] }};">
                                </span>
                                <strong>{{ $category['name'] }}</strong>
                                <small>{{ $category['count'] }}</small>
                            </a>
                        @endforeach
                    </div>
                    <div class="taf-design-showcase">
                        <a href="{{ route('public.products.index', ['category' => 't-shirt']) }}" class="taf-design-hero-card">
                            <img src="{{ asset('images/aurix-tshirt-category.png') }}" alt="Aurix T-shirt collection">
                            <span>T-shirts</span>
                        </a>
                        <a href="{{ route('public.products.index', ['category' => 'polo-t-shirt']) }}" class="taf-design-tile">
                            <img src="{{ asset('images/aurix-polo-category.png') }}" alt="Aurix polo shirts">
                            <span>Polo T-shirts</span>
                        </a>
                        <a href="{{ route('public.products.index', ['category' => 'kids']) }}" class="taf-design-tile">
                            <img src="{{ asset('images/aurix-kids-category.png') }}" alt="Aurix kids clothing">
                            <span>Kids wear</span>
                        </a>
                    </div>
                </div>
            </section>

            <section class="taf-corporate-section" id="corporate">
                <div class="taf-wrap">
                    <div class="taf-corporate-board">
                        <div class="taf-corporate-intro">
                            <img src="{{ asset('images/aurix-branding-logo.png') }}" alt="Aurix Branding logo">
                            <span class="taf-eyebrow">Corporate collection</span>
                            <h2>Professional attire that represents your brand with pride.</h2>
                            <p>Outfit your team with sharp shirts, polos, blazers, embroidery, and refined finishing made for offices, meetings, events, and business travel.</p>
                            <div class="taf-corporate-icons">
                                <span>Premium quality</span>
                                <span>Modern design</span>
                                <span>Comfort focused</span>
                                <span>Built to last</span>
                            </div>
                        </div>
                        <a href="{{ route('public.products.index', ['category' => 'corporate']) }}" class="taf-corporate-product">
                            <img src="{{ asset('images/aurix-tshirt-category.png') }}" alt="Aurix corporate shirts">
                            <strong>Shirt</strong>
                            <small>Tailored fit for a sharp look.</small>
                        </a>
                        <a href="{{ route('public.products.index', ['category' => 'corporate']) }}" class="taf-corporate-product">
                            <img src="{{ asset('images/aurix-polo-category.png') }}" alt="Aurix corporate polo shirts">
                            <strong>Polo shirt</strong>
                            <small>Smart, casual and company ready.</small>
                        </a>
                        <a href="{{ route('public.products.index', ['category' => 'corporate']) }}" class="taf-corporate-product">
                            <img src="{{ asset('images/aurix-branding-collage.png') }}" alt="Aurix corporate branded materials">
                            <strong>Blazer</strong>
                            <small>Professional. Polished. Powerful.</small>
                        </a>
                        <div class="taf-corporate-environments">
                            <h3>Perfect for every professional environment</h3>
                            <div>
                                <span>Corporate office</span>
                                <span>Client meetings</span>
                                <span>Events & conferences</span>
                                <span>Business travel</span>
                            </div>
                        </div>
                        <div class="taf-corporate-team">
                            <img src="{{ asset('images/aurix-polo-category.png') }}" alt="Aurix team corporate uniforms">
                        </div>
                        <div class="taf-corporate-copy">
                            <h3>Elevate your brand identity</h3>
                            <p>Our corporate collection combines sophistication, comfort and durability to ensure your team looks and feels their best every day.</p>
                        </div>
                        <div class="taf-corporate-detail">
                            <img src="{{ asset('images/aurix-hoodie-category.png') }}" alt="Aurix quality embroidery detail">
                            <strong>Quality embroidery</strong>
                            <small>Premium stitching for a lasting impression.</small>
                        </div>
                        <div class="taf-corporate-detail">
                            <img src="{{ asset('images/aurix-branding-collage.png') }}" alt="Aurix premium finish detail">
                            <strong>Premium finish</strong>
                            <small>Attention to detail in every piece.</small>
                        </div>
                        <div class="taf-corporate-detail">
                            <img src="{{ asset('images/aurix-polo-category.png') }}" alt="Aurix tailored corporate comfort">
                            <strong>Tailored comfort</strong>
                            <small>Designed for all-day confidence.</small>
                        </div>
                        <div class="taf-corporate-detail">
                            <img src="{{ asset('images/aurix-tshirt-category.png') }}" alt="Aurix breathable corporate fabric">
                            <strong>Breathable fabric</strong>
                            <small>Stay cool, comfortable and confident.</small>
                        </div>
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
                        <img src="{{ asset('images/aurix-branding-collage.png') }}" alt="Aurix branded apparel and print materials">
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
                                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
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
                    <a href="{{ $whatsappUrl }}">WhatsApp Quote</a>
                    @if($contact['email'])
                        <a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a>
                    @endif
                    @if($contact['address'])
                        <span>{{ $contact['address'] }}</span>
                    @endif
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
        <a class="taf-whatsapp-float" href="{{ $whatsappUrl }}" target="_blank" rel="noopener" aria-label="Chat with Aurix Branding on WhatsApp">
            <svg viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                <path fill="currentColor" d="M16.02 3.2c-7.06 0-12.8 5.68-12.8 12.68 0 2.24.6 4.42 1.74 6.34L3.1 29l6.98-1.82a12.9 12.9 0 0 0 5.94 1.46c7.06 0 12.8-5.68 12.8-12.68S23.08 3.2 16.02 3.2Zm0 23.28c-1.9 0-3.76-.5-5.38-1.44l-.38-.22-4.14 1.08 1.1-4.02-.24-.42a10.35 10.35 0 0 1-1.6-5.58c0-5.8 4.78-10.52 10.64-10.52s10.64 4.72 10.64 10.52-4.78 10.6-10.64 10.6Zm5.82-7.88c-.32-.16-1.9-.94-2.2-1.04-.3-.12-.52-.16-.74.16-.22.32-.84 1.04-1.04 1.26-.18.22-.38.24-.7.08-.32-.16-1.36-.5-2.58-1.58-.96-.84-1.6-1.88-1.78-2.2-.18-.32-.02-.5.14-.66.14-.14.32-.38.48-.56.16-.18.22-.32.32-.54.1-.22.06-.4-.02-.56-.08-.16-.74-1.78-1.02-2.44-.26-.64-.54-.56-.74-.56h-.64c-.22 0-.56.08-.86.4-.3.32-1.14 1.1-1.14 2.68s1.18 3.12 1.34 3.34c.16.22 2.32 3.52 5.62 4.94.78.34 1.4.54 1.88.7.8.24 1.52.2 2.08.12.64-.1 1.9-.78 2.16-1.52.26-.74.26-1.38.18-1.52-.08-.14-.28-.22-.6-.38Z"/>
            </svg>
        </a>
    </body>
</html>
