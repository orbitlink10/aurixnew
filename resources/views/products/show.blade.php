<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | {{ config('app.name') }}</title>
    <meta name="description" content="{{ $product->meta_description ?: Str::limit(strip_tags($product->description ?? ''), 155) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: #f7f3ea;
            color: #17140f;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        a { color: inherit; text-decoration: none; }
        button, input { font: inherit; }
        .wrap {
            width: min(100% - 32px, 1240px);
            margin: 0 auto;
        }
        .helpbar {
            background: #fffaf1;
            border-bottom: 1px solid rgba(23, 20, 15, 0.13);
            color: #6f675b;
            font-size: 13px;
        }
        .helpbar .wrap,
        .header .wrap,
        .dealbar .wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }
        .helpbar .wrap {
            min-height: 34px;
        }
        .helpbar strong {
            color: #17140f;
        }
        .header {
            background: #fffaf1;
            border-bottom: 1px solid rgba(23, 20, 15, 0.13);
        }
        .header .wrap {
            min-height: 74px;
        }
        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: #17140f;
            font-size: 18px;
            font-weight: 900;
            white-space: nowrap;
        }
        .brand img {
            width: 54px;
            height: 54px;
            flex: 0 0 54px;
            border-radius: 2px;
            object-fit: cover;
        }
        .nav {
            display: flex;
            gap: 20px;
            color: #17140f;
            font-size: 14px;
            font-weight: 800;
        }
        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 800;
        }
        .quote-btn {
            border-radius: 999px;
            background: linear-gradient(135deg, #c9942f, #f1cf7a);
            color: #111111;
            padding: 10px 14px;
        }
        .dealbar {
            background: #111111;
            color: #fffaf1;
        }
        .dealbar .wrap {
            min-height: 46px;
            justify-content: center;
            font-size: 14px;
            font-weight: 900;
            text-align: center;
        }
        .subbar {
            background: #fffaf1;
            border-bottom: 1px solid rgba(23, 20, 15, 0.13);
        }
        .subbar .wrap {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            padding: 12px 0;
        }
        .subbar-card {
            border: 1px solid rgba(23, 20, 15, 0.13);
            border-radius: 10px;
            background: #fffaf1;
            padding: 12px;
        }
        .subbar-card strong {
            display: block;
            font-size: 14px;
        }
        .subbar-card span {
            display: block;
            margin-top: 3px;
            color: #6f675b;
            font-size: 12px;
        }
        .breadcrumb {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 18px 0;
            color: #6f675b;
            font-size: 14px;
            font-weight: 700;
        }
        .breadcrumb a {
            color: #c9942f;
        }
        .product-top {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(380px, 0.76fr);
            gap: 34px;
            align-items: start;
        }
        .gallery {
            display: grid;
            grid-template-columns: 88px minmax(0, 1fr);
            gap: 16px;
            position: sticky;
            top: 18px;
        }
        .thumbs {
            display: grid;
            align-content: start;
            gap: 12px;
        }
        .thumb {
            display: grid;
            width: 100%;
            aspect-ratio: 1;
            border: 2px solid transparent;
            border-radius: 10px;
            background: #ffffff;
            padding: 6px;
            box-shadow: 0 1px 0 rgba(23, 20, 15, 0.06);
            cursor: pointer;
            place-items: center;
        }
        .thumb.is-active {
            border-color: #c9942f;
        }
        .thumb img,
        .hero-media img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .thumb img {
            border-radius: 7px;
        }
        .hero-media {
            display: grid;
            height: min(62vw, 620px);
            min-height: 460px;
            place-items: center;
            overflow: hidden;
            border-radius: 14px;
            background: #fffaf1;
            padding: 18px;
            box-shadow: 0 14px 36px rgba(23, 20, 15, 0.08);
        }
        .image-empty {
            display: grid;
            width: 100%;
            min-height: 420px;
            place-items: center;
            border-radius: 12px;
            background: #efe7d8;
            color: #6f675b;
            font-weight: 800;
        }
        .choice-panel {
            border-radius: 14px;
            background: #fffaf1;
            padding: 26px;
            box-shadow: 0 14px 36px rgba(23, 20, 15, 0.08);
        }
        .rating {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6f675b;
            font-size: 14px;
            font-weight: 800;
        }
        .stars {
            color: #f59e0b;
            letter-spacing: 1px;
        }
        h1 {
            margin: 12px 0 12px;
            font-size: clamp(2rem, 4vw, 3.4rem);
            line-height: 1.06;
            letter-spacing: 0;
        }
        .summary {
            color: #6f675b;
            font-size: 16px;
            line-height: 1.7;
        }
        .read-more {
            display: inline-flex;
            margin-top: 8px;
            color: #c9942f;
            font-weight: 900;
        }
        .product-facts {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
            margin: 22px 0;
        }
        .fact {
            border: 1px solid rgba(23, 20, 15, 0.13);
            border-radius: 10px;
            padding: 12px;
        }
        .fact span {
            display: block;
            color: #6f675b;
            font-size: 12px;
            font-weight: 800;
        }
        .fact strong {
            display: block;
            margin-top: 4px;
            font-size: 18px;
            font-weight: 900;
        }
        .benefits {
            margin: 0 0 22px;
            padding: 0;
            list-style: none;
        }
        .benefits li {
            display: flex;
            gap: 9px;
            margin-top: 8px;
            color: #17140f;
            font-weight: 700;
        }
        .benefits li::before {
            content: "";
            width: 8px;
            height: 8px;
            flex: 0 0 auto;
            margin-top: 8px;
            border-radius: 999px;
            background: #c9942f;
        }
        .option-group {
            margin-top: 18px;
        }
        .option-label {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 900;
        }
        .option-label span {
            color: #6f675b;
            font-weight: 700;
        }
        .option-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }
        .option {
            border: 1px solid rgba(23, 20, 15, 0.13);
            border-radius: 10px;
            background: #fff;
            padding: 12px;
            color: #17140f;
            font-weight: 800;
        }
        .option.is-selected {
            border-color: #c9942f;
            background: rgba(201, 148, 47, 0.12);
            color: #17140f;
            box-shadow: inset 0 0 0 1px #c9942f;
        }
        .quantity-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 18px;
        }
        .qty-box,
        .price-box {
            border: 1px solid rgba(23, 20, 15, 0.13);
            border-radius: 10px;
            background: #ffffff;
            padding: 13px;
        }
        .qty-box span,
        .price-box span {
            display: block;
            color: #6f675b;
            font-size: 12px;
            font-weight: 800;
        }
        .qty-control {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 7px;
        }
        .qty-control button {
            width: 30px;
            height: 30px;
            border: 1px solid rgba(23, 20, 15, 0.18);
            border-radius: 8px;
            background: #fff;
            cursor: pointer;
            font-weight: 900;
        }
        .qty-control input {
            width: 54px;
            border: 0;
            background: transparent;
            text-align: center;
            font-weight: 900;
        }
        .price-box strong {
            display: block;
            margin-top: 5px;
            font-size: 24px;
            font-weight: 900;
        }
        .each {
            color: #6f675b;
            font-size: 13px;
            font-weight: 700;
        }
        .cta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 18px;
        }
        .cta {
            display: inline-flex;
            min-height: 48px;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            padding: 0 16px;
            font-weight: 900;
            text-align: center;
        }
        .cta.primary {
            background: linear-gradient(135deg, #c9942f, #f1cf7a);
            color: #111111;
        }
        .cta.secondary {
            border: 1px solid #c9942f;
            background: #fff;
            color: #17140f;
        }
        .later {
            margin-top: 12px;
            border: 1px dashed rgba(201, 148, 47, 0.5);
            border-radius: 10px;
            padding: 13px;
            color: #17140f;
            text-align: center;
            font-weight: 800;
        }
        .share {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 16px;
            color: #6f675b;
            font-size: 13px;
            font-weight: 800;
        }
        .tabs {
            position: sticky;
            top: 0;
            z-index: 5;
            margin-top: 44px;
            border-top: 1px solid rgba(23, 20, 15, 0.13);
            border-bottom: 1px solid rgba(23, 20, 15, 0.13);
            background: rgba(255, 250, 241, 0.96);
            backdrop-filter: blur(12px);
        }
        .tabs .wrap {
            display: flex;
            gap: 28px;
            overflow-x: auto;
        }
        .tabs a {
            padding: 17px 0;
            color: #6f675b;
            font-weight: 900;
            white-space: nowrap;
        }
        .tabs a:first-child {
            color: #c9942f;
        }
        .content-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 330px;
            gap: 34px;
            padding: 42px 0 64px;
        }
        .content-card {
            border-radius: 14px;
            background: #fffaf1;
            padding: 28px;
            box-shadow: 0 14px 36px rgba(23, 20, 15, 0.06);
        }
        .content-card h2 {
            margin: 0 0 16px;
            font-size: clamp(1.8rem, 3vw, 2.6rem);
            line-height: 1.1;
        }
        .content-card h3 {
            margin: 28px 0 10px;
            font-size: 1.35rem;
        }
        .content-card p,
        .content-card li {
            color: #6f675b;
            line-height: 1.75;
        }
        .benefit-icons {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-top: 20px;
        }
        .benefit-icon {
            border: 1px solid rgba(23, 20, 15, 0.13);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            font-weight: 900;
        }
        .benefit-icon span {
            display: grid;
            width: 42px;
            height: 42px;
            place-items: center;
            margin: 0 auto 9px;
            border-radius: 999px;
            background: rgba(201, 148, 47, 0.14);
            color: #c9942f;
        }
        .side-card {
            position: sticky;
            top: 78px;
            align-self: start;
        }
        .spec-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .spec-list li {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            border-bottom: 1px solid rgba(23, 20, 15, 0.13);
            padding: 13px 0;
            color: #6f675b;
        }
        .spec-list strong {
            color: #17140f;
            text-align: right;
        }
        .footer {
            background: #111111;
            color: #fffaf1;
            padding: 34px 0;
        }
        .footer .wrap {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }
        .footer p {
            margin: 0;
            color: rgba(255, 250, 241, 0.72);
        }
        @media (max-width: 980px) {
            .nav,
            .header-actions {
                display: none;
            }
            .product-top,
            .content-grid {
                grid-template-columns: 1fr;
            }
            .gallery,
            .side-card {
                position: static;
            }
            .subbar .wrap,
            .benefit-icons {
                grid-template-columns: 1fr;
            }
        }
        @media (max-width: 680px) {
            .wrap {
                width: min(100% - 24px, 1240px);
            }
            .helpbar .wrap,
            .header .wrap {
                align-items: flex-start;
                flex-direction: column;
                padding: 12px 0;
            }
            .gallery {
                grid-template-columns: 1fr;
            }
            .thumbs {
                display: flex;
                order: 2;
                overflow-x: auto;
            }
            .thumb {
                width: 78px;
                flex: 0 0 auto;
            }
            .hero-media {
                min-height: 320px;
            }
            .product-facts,
            .option-grid,
            .quantity-row,
            .cta-grid {
                grid-template-columns: 1fr;
            }
            .choice-panel,
            .content-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    @php
        $categoryName = $product->category?->name ?: $product->category_name ?: 'Product';
        $summary = trim(strip_tags($product->meta_description ?: $product->description ?: 'Custom printed products made for business events, promotional campaigns, retail packaging, and everyday brand visibility.'));
        $price = (float) $product->price;
        $markedPrice = (float) ($product->marked_price ?? 0);
        $quantity = max(1, (int) ($product->quantity ?: 10));
        $unitPrice = $quantity > 0 && $price > 0 ? $price / $quantity : $price;
        $galleryImages = collect([$product->image_url])
            ->merge($product->relationLoaded('images') ? $product->images->pluck('image_url') : [])
            ->filter()
            ->unique()
            ->values();
        $benefits = [
            'Ideal for business events, gifts, and brand campaigns.',
            'Upload your finished artwork or request design support.',
            'Durable production with clean, full-color finishing.',
            'Nationwide delivery and responsive quote support.',
        ];
    @endphp

    <div class="helpbar">
        <div class="wrap">
            <span>Need Help? <strong>+254 745 506 619</strong></span>
            <span>Design Online | My Projects | Sign In | 0 Cart</span>
        </div>
    </div>

    <header class="header">
        <div class="wrap">
            <a href="{{ url('/') }}" class="brand">
                <img src="{{ asset('images/aurix-branding-logo.png') }}" alt="Aurix Branding logo">
                <span>Aurix Branding</span>
            </a>
            <nav class="nav" aria-label="Main navigation">
                <a href="{{ route('public.products.index') }}">All Products</a>
                <a href="{{ route('public.products.index', ['q' => 'Signs']) }}">Signs & Banners</a>
                <a href="{{ route('public.products.index', ['q' => 'Stationery']) }}">Stationery</a>
                <a href="{{ route('public.products.index', ['q' => 'Apparel']) }}">Apparel</a>
                <a href="{{ route('public.products.index', ['q' => 'Promotional']) }}">Promotional Items</a>
            </nav>
            <div class="header-actions">
                <a href="{{ url('/login') }}">Sign In</a>
                <a href="https://wa.me/254745506619?text=Hello%20Aurix%20Branding%2C%20I%20need%20a%20quote%20for%20{{ urlencode($product->name) }}." class="quote-btn">Get a Quote</a>
            </div>
        </div>
    </header>

    <div class="dealbar">
        <div class="wrap">FREE DESIGN CHECK ON ALL ORDERS | SAME-DAY QUOTE SUPPORT | NATIONWIDE DELIVERY</div>
    </div>

    <section class="subbar" aria-label="Service highlights">
        <div class="wrap">
            <div class="subbar-card"><strong>Bulk order savings</strong><span>Buy more and reduce your unit cost.</span></div>
            <div class="subbar-card"><strong>Artwork support</strong><span>Upload files now or design after ordering.</span></div>
            <div class="subbar-card"><strong>Local production</strong><span>Reliable branding, print, and finishing.</span></div>
        </div>
    </section>

    <main>
        <div class="wrap">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <span>/</span>
                <a href="{{ route('public.products.index') }}">Products</a>
                <span>/</span>
                <span>{{ $product->name }}</span>
            </nav>

            <section class="product-top">
                <div class="gallery">
                    <div class="thumbs" aria-label="Product gallery thumbnails">
                        @forelse($galleryImages as $imageUrl)
                            <button
                                class="thumb {{ $loop->first ? 'is-active' : '' }}"
                                type="button"
                                data-gallery-thumb
                                data-gallery-src="{{ $imageUrl }}"
                                aria-label="View {{ $product->name }} image {{ $loop->iteration }}"
                            >
                                <img src="{{ $imageUrl }}" alt="{{ $product->name }} thumbnail {{ $loop->iteration }}">
                            </button>
                        @empty
                            <div class="thumb is-active">
                                <div class="image-empty">Image</div>
                            </div>
                        @endforelse
                    </div>
                    <div class="hero-media">
                        @if($galleryImages->isNotEmpty())
                            <img id="productMainImage" src="{{ $galleryImages->first() }}" alt="{{ $product->name }}">
                        @else
                            <div class="image-empty">No product image</div>
                        @endif
                    </div>
                </div>

                <aside class="choice-panel">
                    <div class="rating">
                        <span class="stars">★★★★☆</span>
                        <span>4.0 | 1 review</span>
                    </div>
                    <h1>{{ $product->name }}</h1>
                    <p class="summary">{{ Str::limit($summary, 190) }}</p>
                    @if($product->description)
                        <a href="#overview" class="read-more">Read More</a>
                    @endif

                    <div class="product-facts">
                        <div class="fact"><span>Minimum Qty</span><strong>{{ $quantity }}</strong></div>
                        <div class="fact"><span>Starting at</span><strong>KES {{ number_format($price, 0) }}</strong></div>
                        <div class="fact"><span>Category</span><strong>{{ Str::limit($categoryName, 16) }}</strong></div>
                    </div>

                    <ul class="benefits">
                        @foreach($benefits as $benefit)
                            <li>{{ $benefit }}</li>
                        @endforeach
                    </ul>

                    <div class="option-group">
                        <div class="option-label">Size <span>Choose a format</span></div>
                        <div class="option-grid">
                            <div class="option is-selected">Standard</div>
                            <div class="option">Custom Size</div>
                        </div>
                    </div>

                    <div class="option-group">
                        <div class="option-label">Printing Sides <span>Production option</span></div>
                        <div class="option-grid">
                            <div class="option is-selected">Single-Sided</div>
                            <div class="option">Double-Sided +KES 50</div>
                        </div>
                    </div>

                    <div class="option-group">
                        <div class="option-label">Finish <span>Recommended</span></div>
                        <div class="option-grid">
                            <div class="option is-selected">Standard Finish</div>
                            <div class="option">Premium Finish</div>
                        </div>
                    </div>

                    <div class="quantity-row">
                        <div class="qty-box">
                            <span>Quantity</span>
                            <div class="qty-control">
                                <button type="button">-</button>
                                <input value="{{ $quantity }}" aria-label="Quantity">
                                <button type="button">+</button>
                            </div>
                        </div>
                        <div class="price-box">
                            <span>Price</span>
                            <strong>KES {{ number_format($price, 2) }}</strong>
                            @if($unitPrice > 0)
                                <div class="each">KES {{ number_format($unitPrice, 2) }} each</div>
                            @endif
                            @if($markedPrice > $price)
                                <div class="each">Was KES {{ number_format($markedPrice, 2) }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="cta-grid">
                        <a href="https://wa.me/254745506619?text=Hello%20Aurix%20Branding%2C%20I%20want%20to%20upload%20artwork%20for%20{{ urlencode($product->name) }}." class="cta primary">Upload Design</a>
                        <a href="https://wa.me/254745506619?text=Hello%20Aurix%20Branding%2C%20I%20need%20design%20help%20for%20{{ urlencode($product->name) }}." class="cta secondary">Design Online</a>
                    </div>
                    <div class="later">Artwork not ready? Buy now and design later.</div>
                    <div class="share">
                        <span>Share Product</span>
                        <span>SKU: AURIX-{{ str_pad((string) $product->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </aside>
            </section>
        </div>

        <nav class="tabs" aria-label="Product content">
            <div class="wrap">
                <a href="#overview">Overview</a>
                <a href="#specifications">Specifications</a>
                <a href="#design">Design</a>
                <a href="#faq">FAQ</a>
                <a href="{{ route('public.products.index') }}">Related Products</a>
            </div>
        </nav>

        <section class="wrap content-grid">
            <article class="content-card" id="overview">
                <h2>{{ $product->name }} Overview</h2>
                @if($product->description)
                    {!! $product->description !!}
                @else
                    <p>{{ $product->name }} is prepared for professional brand visibility, customer engagement, events, retail packaging, and promotional giveaways. Use it to keep your logo in front of the right audience with a polished custom finish.</p>
                    <p>Send your artwork, request help from our design team, or confirm the production specifications after placing your order. Aurix Branding will guide the right material, finish, and delivery plan for your project.</p>
                @endif

                <h3>Benefits of Custom {{ $categoryName }}</h3>
                <div class="benefit-icons">
                    @foreach(['Versatile', 'Memorable', 'Lightweight', 'Modern', 'Affordable', 'Impactful'] as $benefit)
                        <div class="benefit-icon"><span>✓</span>{{ $benefit }}</div>
                    @endforeach
                </div>

                <h3 id="design">Design Support</h3>
                <p>Upload your finished artwork, send a logo, or request a fresh design. We can check sizing, resolution, placement, bleed, and production readiness before printing.</p>

                <h3 id="faq">Frequently Asked Questions</h3>
                <p><strong>Can I order before my artwork is ready?</strong><br>Yes. Send your details through WhatsApp and our team will help you finalize artwork after quote confirmation.</p>
                <p><strong>Do you support bulk orders?</strong><br>Yes. Bulk orders can be quoted with quantity-based pricing depending on the material, finishing, and timeline.</p>
            </article>

            <aside class="content-card side-card" id="specifications">
                <h2>Specifications</h2>
                <ul class="spec-list">
                    <li><span>Product</span><strong>{{ $product->name }}</strong></li>
                    <li><span>Category</span><strong>{{ $categoryName }}</strong></li>
                    <li><span>Subcategory</span><strong>{{ $product->subcategory_name ?: 'Custom print' }}</strong></li>
                    <li><span>Availability</span><strong>{{ $product->is_active ? 'Available' : 'Inactive' }}</strong></li>
                    <li><span>Minimum Quantity</span><strong>{{ $quantity }}</strong></li>
                    <li><span>Starting Price</span><strong>KES {{ number_format($price, 2) }}</strong></li>
                    <li><span>Artwork</span><strong>Upload or design online</strong></li>
                    <li><span>Delivery</span><strong>Nationwide</strong></li>
                </ul>
            </aside>
        </section>
    </main>

    <footer class="footer">
        <div class="wrap">
            <strong>Aurix Branding</strong>
            <p>Custom apparel, print, signage, and promotional products.</p>
            <a href="{{ route('public.products.index') }}">Back to products</a>
        </div>
    </footer>
    <script>
        document.querySelectorAll('[data-gallery-thumb]').forEach((thumb) => {
            thumb.addEventListener('click', () => {
                const mainImage = document.getElementById('productMainImage');
                const nextSource = thumb.dataset.gallerySrc;

                if (!mainImage || !nextSource) {
                    return;
                }

                mainImage.src = nextSource;
                document.querySelectorAll('[data-gallery-thumb]').forEach((item) => item.classList.remove('is-active'));
                thumb.classList.add('is-active');
            });
        });
    </script>
</body>
</html>
