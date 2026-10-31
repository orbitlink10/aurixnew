@extends('layouts.taf')

@section('title', 'Branding & Printing in Nairobi, Kenya | Aurix Branding')
@section('meta_description', 'Custom T-shirt and apparel printing, corporate branding, uniforms, embroidery, promotional merchandise, signage, and business printing in Nairobi with nationwide delivery across Kenya.')

@section('marquee')
    <div class="taf-marquee" aria-hidden="true">
        <div class="taf-marquee-track">
            @foreach(range(1, 3) as $repeat)
                <span>Premium Branding Solutions - Custom T-Shirts - Corporate Gifts - Vehicle Branding - Signage &amp; Roll-Up Banners - Business Cards - High-Quality Printing - Nationwide Delivery - Free Quotes</span>
            @endforeach
        </div>
    </div>
    <span class="sr-only">Premium branding solutions: custom T-shirts, corporate gifts, vehicle branding, signage, business cards, high-quality printing, and nationwide delivery.</span>
@endsection

@section('content')
    @php
        $contact = $contactSettings ?? \App\Models\SiteSetting::defaultContactSettings();
        $displayPhone = $contact['phone'] ?? '+254 700816670';
        $whatsappPhone = preg_replace('/\D+/', '', $contact['whatsapp_phone'] ?? $displayPhone);
        $whatsappPhone = $whatsappPhone ?: '254700816670';
        $whatsappUrl = 'https://wa.me/'.$whatsappPhone.'?text='.rawurlencode($contact['whatsapp_message'] ?? 'Hello Aurix Branding, I need a quote.');
        $quoteUrl = route('public.quote');

        $homepageCategoryRecords = isset($homepageCategories) ? collect($homepageCategories) : collect();
        $homepageCategoryCards = $homepageCategoryRecords->count()
            ? $homepageCategoryRecords->map(fn ($category) => [
                'name' => $category->name,
                'image' => $category->image_url ?: asset('images/aurix-design-categories.png'),
                'item_count' => $category->item_count ?? $category->products_count ?? null,
                'href' => route('public.products.index', ['category' => $category->slug ?? \Illuminate\Support\Str::slug($category->name)]),
            ])->values()->all()
            : [];

        $homepageHeroImages = !empty($heroImageUrls) ? array_values($heroImageUrls) : [];
        $homepageHeroVideoEmbedUrl = $heroVideoEmbedUrl ?? null;
        $homepageHeroFallbackImage = $homepageHeroImages[0] ?? asset('images/aurix-branding-collage.png');

        $homepageProductRecords = isset($homepageProducts) ? collect($homepageProducts) : collect();
        $homepageProductCards = $homepageProductRecords->count()
            ? $homepageProductRecords->map(fn ($product) => [
                'name' => $product->name,
                'image' => $product->display_image_url ?: asset('images/aurix-branding-collage.png'),
                'href' => route('public.products.show', ['product' => $product->slug]),
            ])->values()->all()
            : [];
    @endphp

    <section class="taf-hero" aria-labelledby="home-hero-title">
        <div class="taf-wrap taf-hero-grid">
            <div class="taf-hero-copy">
                <span class="taf-eyebrow">Same day custom printing</span>
                <h1 id="home-hero-title">Branding and <span>Printing Services</span> in Nairobi, Kenya</h1>
                <p>Custom tees, uniforms, event merchandise, branded gifts, signage, and business print with sharp artwork setup and reliable production support across Kenya.</p>
                <div class="taf-hero-services" aria-label="Printing and branding services">
                    <span>DTF transfers</span>
                    <span>Embroidery</span>
                    <span>Screen printing</span>
                    <span>Vinyl names</span>
                    <span>Signage</span>
                </div>
                <div class="taf-hero-actions">
                    <a href="{{ route('public.products.index', ['q' => 't-shirt']) }}" class="taf-primary-btn">Browse T-Shirts</a>
                    <a href="{{ $quoteUrl }}" class="taf-link-btn">Request a Quote</a>
                </div>
            </div>
            <div class="taf-hero-video-panel" aria-label="Aurix Branding production preview">
                <div class="taf-hero-video-frame" @if(count($homepageHeroImages) > 0) data-hero-images @endif>
                    @if(count($homepageHeroImages) > 0)
                        @foreach($homepageHeroImages as $index => $heroImg)
                            <img src="{{ $heroImg }}" alt="Aurix Branding custom branding and printing work" width="1200" height="750" @if($index === 0) fetchpriority="high" @endif @if($index > 0) hidden @endif>
                        @endforeach
                    @elseif($homepageHeroVideoEmbedUrl)
                        <iframe src="{{ $homepageHeroVideoEmbedUrl }}" title="Aurix Branding custom printing video" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    @else
                        <img src="{{ $homepageHeroFallbackImage }}" alt="Aurix Branding custom branding and printing preview" width="1200" height="750" fetchpriority="high">
                        <span class="taf-hero-play" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="taf-section taf-category-section">
        <div class="taf-wrap">
            <div class="taf-category-head">
                <div>
                    <span class="taf-category-kicker">Browse by category</span>
                    <h2>Branding categories</h2>
                </div>
                <a href="{{ route('public.products.index') }}">View all products <span aria-hidden="true">&#8599;</span></a>
            </div>
            <div class="taf-category-row">
                @forelse($homepageCategoryCards as $category)
                    <a href="{{ $category['href'] }}" class="taf-category-card">
                        <span class="taf-category-media">
                            <img src="{{ $category['image'] }}" alt="{{ $category['name'] }}" loading="lazy" width="300" height="300">
                        </span>
                        <strong>{{ $category['name'] }}</strong>
                    </a>
                @empty
                    <p class="taf-dashboard-empty">Branding categories will be added soon.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section id="work" class="taf-section taf-work-section">
        <div class="taf-wrap">
            <div class="taf-category-head">
                <div>
                    <span class="taf-category-kicker">Our work</span>
                    <h2>Recent branding projects</h2>
                </div>
                <a href="{{ route('public.portfolio') }}">View our work <span aria-hidden="true">&#8599;</span></a>
            </div>
            <div class="taf-work-grid">
                @forelse($portfolio ?? [] as $item)
                    <a href="{{ $item['href'] }}" class="taf-work-card">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" loading="lazy" width="600" height="450">
                        <strong>{{ $item['title'] }}</strong>
                    </a>
                @empty
                    <p class="taf-dashboard-empty">Recent branding projects will be added soon.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="taf-section taf-home-products">
        <div class="taf-wrap">
            <div class="taf-product-section-head">
                <div>
                    <span>Featured products</span>
                    <h2>Popular items</h2>
                </div>
                <p>Custom branding <span></span> Ready to quote</p>
            </div>

            <div class="taf-product-grid">
                @forelse($homepageProductCards as $product)
                    <a href="{{ $product['href'] }}" class="taf-product-card">
                        <span class="taf-product-media">
                            @if($product['image'])
                                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" loading="lazy" width="400" height="400">
                            @else
                                <span class="taf-product-placeholder">No image</span>
                            @endif
                            <span class="taf-customize-btn">Request Quote</span>
                        </span>
                        <span class="taf-product-info">
                            <strong>{{ $product['name'] }}</strong>
                            <span class="taf-product-quote">Request a tailored quote</span>
                        </span>
                    </a>
                @empty
                    <p class="taf-dashboard-empty">No products have been added yet.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
