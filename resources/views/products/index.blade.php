<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | {{ config('app.name') }}</title>
    <meta name="description" content="Shop Aurix Branding custom apparel, print, embroidery, and promotional products.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #c9942f;
            --gold-light: #f1cf7a;
            --charcoal: #111111;
            --ink: #17140f;
            --muted: #6f675b;
            --line: rgba(23, 20, 15, 0.13);
            --soft: #f7f3ea;
            --ivory: #fffaf1;
        }
        * { box-sizing: border-box; }
        html, body { max-width: 100%; overflow-x: hidden; }
        body { margin: 0; background: var(--soft); color: var(--ink); font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 15px; }
        a { color: inherit; text-decoration: none; }
        button, input, select { font: inherit; }
        .shop-marquee { overflow: hidden; background: linear-gradient(90deg, #050505, #17140f, #050505); border-bottom: 1px solid rgba(241, 207, 122, 0.32); color: #fffaf1; font-size: 13px; font-weight: 900; letter-spacing: 0.04em; text-transform: uppercase; }
        .shop-marquee-track { display: flex; width: max-content; min-width: 200%; gap: 34px; padding: 9px 0; animation: shopMarquee 28s linear infinite; }
        .shop-marquee span { white-space: nowrap; }
        @keyframes shopMarquee { from { transform: translateX(0); } to { transform: translateX(-50%); } }
        .shop-header { position: sticky; top: 0; z-index: 30; background: rgba(255, 250, 241, 0.96); border-bottom: 1px solid var(--line); backdrop-filter: blur(14px); }
        .shop-wrap { width: min(1530px, calc(100% - 56px)); margin: 0 auto; }
        .shop-nav { display: grid; min-height: 92px; grid-template-columns: 240px minmax(0, 1fr) auto; align-items: center; gap: 22px; }
        .brand { display: inline-flex; min-width: 0; align-items: center; gap: 12px; color: var(--ink); font-size: 18px; font-weight: 900; white-space: nowrap; }
        .brand img { width: 54px; height: 54px; flex: 0 0 54px; border-radius: 2px; object-fit: cover; }
        .brand span { overflow: hidden; text-overflow: ellipsis; }
        .nav-links { display: flex; min-width: 0; justify-content: center; gap: clamp(12px, 1.15vw, 22px); overflow-x: auto; scrollbar-width: none; font-size: 14px; font-weight: 700; white-space: nowrap; }
        .nav-links::-webkit-scrollbar { display: none; }
        .nav-links a.is-active { color: var(--gold); }
        .header-icons { display: flex; gap: 12px; }
        .icon-btn { display: grid; width: 46px; height: 46px; place-items: center; border: 1px solid var(--line); border-radius: 999px; background: #fffaf1; color: var(--ink); }
        .icon-btn svg { width: 21px; height: 21px; }
        .category-ribbon { background: #0c0c0c; color: #fffaf1; }
        .category-ribbon .shop-wrap { display: flex; min-height: 60px; align-items: center; justify-content: flex-start; gap: clamp(22px, 3vw, 40px); overflow-x: auto; scrollbar-width: none; }
        .category-ribbon .shop-wrap::-webkit-scrollbar { display: none; }
        .category-ribbon a { flex: 0 0 auto; color: #fffaf1; font-size: 16px; font-weight: 900; white-space: nowrap; }
        .category-ribbon a.is-active { color: var(--gold-light); }
        .ribbon-item { display: grid; min-width: 78px; justify-items: center; gap: 7px; font-size: 12px; font-weight: 700; }
        .ribbon-icon { display: grid; width: 38px; height: 38px; place-items: center; border-radius: 999px; background: rgba(241, 207, 122, .14); font-size: 18px; }
        .see-all { min-width: 142px; border: 1px solid rgba(241, 207, 122, .46); border-radius: 999px; padding: 12px 20px; text-align: center; font-size: 13px; font-weight: 900; }
        .shop-main { padding: 44px 0 70px; }
        .eyebrow { margin: 0 0 10px; color: var(--muted); font-size: 14px; font-weight: 600; letter-spacing: .34em; text-transform: uppercase; }
        h1 { margin: 0; font-size: clamp(2rem, 3.6vw, 3.4rem); font-weight: 500; letter-spacing: 0; }
        .search-panel { display: grid; grid-template-columns: 1fr auto auto; gap: 22px; align-items: center; margin: 36px 0 34px; padding: 22px 28px; border: 1px solid var(--line); border-radius: 30px; background: #fffaf1; box-shadow: 0 18px 38px rgba(23, 20, 15, .06); }
        .search-box { display: grid; grid-template-columns: auto 1fr auto; align-items: center; gap: 14px; min-height: 68px; border: 1px solid var(--line); border-radius: 999px; background: #ffffff; padding: 0 22px; }
        .search-box input { width: 100%; border: 0; background: transparent; color: var(--ink); outline: 0; font-size: 16px; }
        .search-box button, .apply-btn { border: 0; border-radius: 999px; background: linear-gradient(135deg, var(--gold), var(--gold-light)); color: var(--charcoal); padding: 14px 28px; font-weight: 900; letter-spacing: .18em; text-transform: uppercase; cursor: pointer; }
        .round-action { display: grid; width: 58px; height: 58px; place-items: center; border: 1px solid var(--line); border-radius: 999px; background: #fffaf1; color: var(--ink); }
        .shop-layout { display: grid; grid-template-columns: 326px 1fr; gap: 34px; align-items: start; }
        .filters { position: sticky; top: 128px; border: 1px solid var(--line); border-radius: 28px; background: #fffaf1; padding: 28px; box-shadow: 0 18px 38px rgba(23, 20, 15, .06); }
        .filters h2 { margin: 0 0 30px; font-size: 21px; font-weight: 500; }
        .filter-block { margin-top: 28px; }
        .filter-title { display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 17px; font-weight: 600; }
        .radio-row { display: flex; align-items: center; gap: 12px; margin: 15px 0; color: var(--ink); font-size: 16px; }
        .radio-row input { width: 22px; height: 22px; accent-color: var(--gold); }
        .range { width: 100%; accent-color: var(--gold); }
        .range-labels { display: flex; justify-content: space-between; margin-top: 14px; font-size: 15px; }
        .price-input { width: 100%; margin-bottom: 16px; border: 1px solid var(--line); border-radius: 16px; padding: 13px 17px; font-size: 16px; outline: 0; }
        .filter-actions { display: flex; gap: 16px; margin-top: 28px; }
        .reset-btn { display: inline-flex; align-items: center; justify-content: center; border: 1px solid var(--line); border-radius: 999px; background: #fff; color: var(--ink); padding: 14px 28px; font-size: 16px; font-weight: 600; }
        .content-tools { display: flex; align-items: center; justify-content: space-between; gap: 18px; margin-bottom: 32px; }
        .chips { display: flex; flex-wrap: wrap; gap: 14px; }
        .chip { display: inline-flex; border: 1px solid var(--line); border-radius: 999px; background: #fffaf1; padding: 13px 22px; color: var(--ink); font-weight: 500; }
        .sort { display: flex; align-items: center; gap: 14px; font-size: 16px; white-space: nowrap; }
        .sort select { min-width: 218px; border: 1px solid var(--line); border-radius: 14px; background: #fffaf1; padding: 14px 18px; font-size: 16px; }
        .product-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 28px; }
        .product-card { overflow: hidden; border: 1px solid var(--line); border-radius: 28px; background: #fffaf1; box-shadow: 0 18px 38px rgba(23, 20, 15, .06); }
        .product-media { display: grid; aspect-ratio: 1 / .78; margin: 22px 22px 0; place-items: center; overflow: hidden; border-radius: 22px; background: #efe7d8; }
        .product-media img { width: 100%; height: 100%; object-fit: cover; }
        .product-info { padding: 22px; }
        .product-meta { display: flex; justify-content: space-between; gap: 12px; color: var(--ink); font-size: 14px; }
        .product-info h2 { margin: 20px 0 10px; font-size: 18px; line-height: 1.35; }
        .price { display: block; margin-bottom: 18px; font-size: 21px; font-weight: 500; }
        .card-bottom { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
        .rating { color: #111; font-size: 14px; }
        .sold { color: #111; font-size: 14px; }
        .card-actions { display: flex; gap: 12px; }
        .small-action { display: grid; width: 54px; height: 54px; place-items: center; border: 1px solid var(--line); border-radius: 999px; background: #fff; color: var(--ink); font-size: 28px; cursor: pointer; }
        .empty-state { border: 1px dashed rgba(201, 148, 47, .42); border-radius: 28px; background: #fffaf1; padding: 52px; text-align: center; }
        .empty-state h2 { margin: 0 0 10px; font-size: 28px; }
        .empty-state p { margin: 0; color: var(--muted); }
        .pagination-wrap { margin-top: 34px; }
        .cart-overlay { position: fixed; inset: 0; z-index: 80; background: rgba(5, 5, 5, .48); opacity: 0; pointer-events: none; transition: opacity .22s ease; }
        .cart-drawer { position: fixed; top: 0; right: 0; z-index: 90; display: grid; width: min(430px, 100vw); height: 100dvh; grid-template-rows: auto 1fr auto; background: #fffaf1; box-shadow: -24px 0 60px rgba(23, 20, 15, .22); transform: translateX(100%); transition: transform .24s ease; }
        body.cart-is-open { overflow: hidden; }
        body.cart-is-open .cart-overlay { opacity: 1; pointer-events: auto; }
        body.cart-is-open .cart-drawer { transform: translateX(0); }
        .cart-head { display: flex; align-items: center; justify-content: space-between; gap: 18px; border-bottom: 1px solid var(--line); padding: 22px 24px; }
        .cart-head h2 { margin: 0; font-size: 24px; font-weight: 800; }
        .cart-close { display: grid; width: 42px; height: 42px; place-items: center; border: 1px solid var(--line); border-radius: 999px; background: #fff; color: var(--ink); font-size: 24px; cursor: pointer; }
        .cart-items { overflow-y: auto; padding: 18px 24px; }
        .cart-empty { margin: 48px auto 0; max-width: 280px; color: var(--muted); text-align: center; line-height: 1.55; }
        .cart-item { display: grid; grid-template-columns: 76px 1fr; gap: 14px; padding: 16px 0; border-bottom: 1px solid var(--line); }
        .cart-item img, .cart-item-placeholder { width: 76px; height: 76px; border-radius: 18px; background: var(--soft); object-fit: cover; }
        .cart-item-placeholder { display: grid; place-items: center; color: var(--muted); font-size: 12px; text-align: center; }
        .cart-item h3 { margin: 0 0 8px; font-size: 15px; line-height: 1.35; }
        .cart-item-price { display: block; color: var(--gold); font-weight: 800; }
        .cart-item-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-top: 12px; }
        .cart-qty { display: inline-flex; align-items: center; gap: 10px; border: 1px solid var(--line); border-radius: 999px; padding: 5px; }
        .cart-qty button { display: grid; width: 28px; height: 28px; place-items: center; border: 0; border-radius: 999px; background: var(--soft); color: var(--ink); cursor: pointer; }
        .cart-remove { border: 0; background: transparent; color: var(--muted); font-weight: 700; cursor: pointer; }
        .cart-foot { border-top: 1px solid var(--line); padding: 20px 24px 24px; }
        .cart-total { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; font-size: 18px; font-weight: 800; }
        .cart-checkout { display: flex; width: 100%; min-height: 50px; align-items: center; justify-content: center; border: 0; border-radius: 999px; background: linear-gradient(135deg, var(--gold), var(--gold-light)); color: var(--charcoal); font-weight: 900; letter-spacing: .08em; text-transform: uppercase; cursor: pointer; }
        @media (max-width: 1320px) {
            .shop-nav { grid-template-columns: 220px minmax(0, 1fr); }
            .header-icons { display: none; }
        }
        @media (max-width: 1180px) {
            .shop-nav { grid-template-columns: 1fr; padding: 18px 0; }
            .nav-links { justify-content: flex-start; overflow-x: auto; }
            .shop-layout { grid-template-columns: 1fr; }
            .filters { position: static; }
            .product-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 720px) {
            .shop-wrap { width: min(100% - 28px, 1530px); }
            .search-panel, .content-tools { grid-template-columns: 1fr; display: grid; }
            .search-box { grid-template-columns: auto 1fr; }
            .search-box button { grid-column: 1 / -1; }
            .round-action { display: none; }
            .product-grid { grid-template-columns: 1fr; }
            .filters { padding: 22px; }
        }
    </style>
</head>
<body>
    @php
        $tickerText = '⭐ Premium Branding Solutions • 👕 Custom T-Shirts • 🎁 Corporate Gifts • 🚗 Vehicle Branding • 🪧 Signage & Roll-Up Banners • 📇 Business Cards • 🎨 Logo Design • 🖨️ High-Quality Printing • ⚡ Same-Day Printing Available • 🚚 Nationwide Delivery • 📞 Free Quotes';
        $ribbonItems = [
            ['Adventure', '☘'], ['Religious', '☯'], ['Movies', '🎬'], ['Television', '📺'], ['Sports', '🏀'],
            ['Vintage', '🧵'], ['Animals', '🐾'], ['Funny', '🤣'], ['onesies', '🧸'], ['Socks', '🧦'],
            ['Hoodies', '🧥'], ['Bags', '💼'],
        ];
        $selectedCategory = request('category', 'all-categories');
    @endphp

    <div class="shop-marquee" aria-label="Shop highlights">
        <div class="shop-marquee-track">
            @foreach(range(1, 2) as $repeat)
                <span>{{ $tickerText }}</span>
            @endforeach
        </div>
    </div>

    <header class="shop-header">
        <div class="shop-wrap shop-nav">
            <a href="{{ url('/') }}" class="brand" aria-label="Aurix Branding home">
                <img src="{{ asset('images/aurix-branding-logo.png') }}" alt="Aurix Branding logo">
                <span>Aurix Branding</span>
            </a>
            <nav class="nav-links" aria-label="Main navigation">
                @foreach(['Home' => url('/'), 'Shop' => route('public.products.index'), 'Men' => route('public.products.index', ['category' => 'men']), 'Women' => route('public.products.index', ['category' => 'women']), 'Jersey' => route('public.products.index', ['category' => 'jersey']), 'Corporate' => route('public.products.index', ['category' => 'corporate']), 'Embroidery' => route('public.embroidery'), 'Remove background' => '#', 'Create Design' => route('public.create-design'), 'Maasai' => route('public.products.index', ['category' => 'maasai'])] as $label => $url)
                    <a href="{{ $url }}" @class(['is-active' => $label === 'Shop'])>{{ $label }}</a>
                @endforeach
            </nav>
            <div class="header-icons" aria-hidden="true">
                <span class="icon-btn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg></span>
                <span class="icon-btn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.4 0-8 2.2-8 5v1h16v-1c0-2.8-3.6-5-8-5Z"/></svg></span>
                <span class="icon-btn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21s-7-4.4-9.2-8.2C.9 9.6 2.6 6 6.2 6c2 0 3.3 1.1 3.8 2 .5-.9 1.8-2 3.8-2 3.6 0 5.3 3.6 3.4 6.8C19 16.6 12 21 12 21Z"/></svg></span>
                <button class="icon-btn" type="button" data-cart-open aria-label="Open cart"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 18a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm10 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4ZM6.2 6l.5 2h12.7l-1.5 6H8L5.6 3H2v2h2l2.3 11H18v-2H8.4L8 12h11.5L22 6H6.2Z"/></svg></button>
            </div>
        </div>
        <div class="category-ribbon">
            <div class="shop-wrap">
                @include('partials.public-main-menu')
            </div>
        </div>
    </header>

    <main class="shop-main">
        <div class="shop-wrap">
            <p class="eyebrow">Browse the latest custom apparel.</p>
            <h1>Shop</h1>

            <form action="{{ route('public.products.index') }}" method="GET" class="search-panel">
                @foreach(['category', 'min_price', 'max_price', 'sort'] as $preservedField)
                    @if(request()->filled($preservedField))
                        <input type="hidden" name="{{ $preservedField }}" value="{{ request($preservedField) }}">
                    @endif
                @endforeach
                <div class="search-box">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Search products...">
                    <button type="submit">Search</button>
                </div>
                <button class="round-action" type="button" data-cart-open aria-label="Open cart">🛒</button>
                <span class="round-action" aria-hidden="true">🔔</span>
            </form>

            <div class="shop-layout">
                <aside class="filters">
                    <h2>Filters</h2>
                    <form action="{{ route('public.products.index') }}" method="GET">
                        @foreach(['q', 'sort'] as $preservedField)
                            @if(request()->filled($preservedField))
                                <input type="hidden" name="{{ $preservedField }}" value="{{ request($preservedField) }}">
                            @endif
                        @endforeach
                        <div class="filter-block">
                            <div class="filter-title"><span>Categories</span><span>▾</span></div>
                            <label class="radio-row"><input type="radio" name="category" value="all-categories" {{ $selectedCategory === 'all-categories' || !request('category') ? 'checked' : '' }}>All categories</label>
                            @foreach($shopCategories as $categoryName)
                                @php $value = \Illuminate\Support\Str::slug($categoryName); @endphp
                                <label class="radio-row"><input type="radio" name="category" value="{{ $value }}" {{ $selectedCategory === $value ? 'checked' : '' }}>{{ $categoryName }}</label>
                            @endforeach
                        </div>
                        <div class="filter-block">
                            <div class="filter-title"><span>Rating</span><span>▾</span></div>
                            <label class="radio-row"><input type="radio" name="rating" value="highest" {{ request('rating', 'highest') === 'highest' ? 'checked' : '' }}>Highest</label>
                            <label class="radio-row"><input type="radio" name="rating" value="lowest" {{ request('rating') === 'lowest' ? 'checked' : '' }}>Lowest</label>
                        </div>
                        <div class="filter-block">
                            <div class="filter-title"><span>Main Order</span><span>▾</span></div>
                            <input class="range" type="range" min="0" max="100" name="main_order" value="{{ request('main_order', 0) }}">
                            <div class="range-labels"><span>0</span><span>100</span></div>
                        </div>
                        <div class="filter-block">
                            <div class="filter-title"><span>Price</span><span>▾</span></div>
                            <input class="price-input" type="number" name="min_price" value="{{ request('min_price', 1000) }}" min="0" placeholder="1000">
                            <input class="price-input" type="number" name="max_price" value="{{ request('max_price', 2000) }}" min="0" placeholder="2000">
                        </div>
                        <div class="filter-actions">
                            <button class="apply-btn" type="submit">Apply</button>
                            <a class="reset-btn" href="{{ route('public.products.index') }}">Reset</a>
                        </div>
                    </form>
                </aside>

                <section>
                    <form action="{{ route('public.products.index') }}" method="GET" class="content-tools">
                        @foreach(['q', 'category', 'min_price', 'max_price'] as $preservedField)
                            @if(request()->filled($preservedField))
                                <input type="hidden" name="{{ $preservedField }}" value="{{ request($preservedField) }}">
                            @endif
                        @endforeach
                        <div class="chips">
                            <span class="chip">Ready to ship</span>
                            <span class="chip">Paid samples</span>
                            @if(request('min_price'))<span class="chip">Min: KSh {{ number_format((float) request('min_price')) }}</span>@endif
                            @if(request('max_price'))<span class="chip">Max: KSh {{ number_format((float) request('max_price')) }}</span>@endif
                        </div>
                        <label class="sort">
                            <span>Sort by:</span>
                            <select name="sort" onchange="this.form.submit()">
                                @foreach(['popular' => 'Popular', 'newest' => 'Newest', 'price_low' => 'Price: Low to High', 'price_high' => 'Price: High to Low'] as $value => $label)
                                    <option value="{{ $value }}" {{ request('sort', 'popular') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </label>
                    </form>

                    @forelse($products as $product)
                        @if($loop->first)<div class="product-grid">@endif
                            <article class="product-card">
                                <a href="{{ route('public.products.show', ['product' => $product->slug]) }}" class="product-media">
                                    @if($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                    @else
                                        <span>No image yet</span>
                                    @endif
                                </a>
                                <div class="product-info">
                                    <div class="product-meta">
                                        <span>{{ $product->category?->name ?: $product->subcategory_name ?: $product->category_name ?: 'Product' }}</span>
                                        <span>{{ $product->subcategory_name ?: $product->category?->name ?: 'Custom' }}</span>
                                    </div>
                                    <h2><a href="{{ route('public.products.show', ['product' => $product->slug]) }}">{{ $product->name }}</a></h2>
                                    <span class="price">KSh {{ number_format((float) $product->price) }}</span>
                                    <div class="card-bottom">
                                        <span class="rating">Star 4.8</span>
                                        <span class="sold">{{ max(0, (int) $product->quantity) }} sold</span>
                                        <div class="card-actions">
                                            <button class="small-action" type="button" aria-label="Save {{ $product->name }}">♡</button>
                                            <button
                                                class="small-action"
                                                type="button"
                                                data-cart-add
                                                data-product-id="{{ $product->id }}"
                                                data-product-name="{{ $product->name }}"
                                                data-product-price="{{ (float) $product->price }}"
                                                data-product-image="{{ $product->image_url }}"
                                                aria-label="Add {{ $product->name }} to cart"
                                            >+</button>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @if($loop->last)</div>@endif
                    @empty
                        <div class="empty-state">
                            <h2>No products yet</h2>
                            <p>Add your own products from the dashboard and they will appear here.</p>
                        </div>
                    @endforelse

                    @if($products->hasPages())
                        <div class="pagination-wrap">{{ $products->links() }}</div>
                    @endif
                </section>
            </div>
        </div>
    </main>
    <div class="cart-overlay" data-cart-close></div>
    <aside class="cart-drawer" aria-label="Shopping cart" aria-hidden="true" data-cart-drawer>
        <div class="cart-head">
            <h2>Your Cart</h2>
            <button class="cart-close" type="button" data-cart-close aria-label="Close cart">×</button>
        </div>
        <div class="cart-items" data-cart-items>
            <p class="cart-empty">Your cart is empty. Add a product and it will appear here.</p>
        </div>
        <div class="cart-foot">
            <div class="cart-total">
                <span>Subtotal</span>
                <strong data-cart-subtotal>KSh 0</strong>
            </div>
            <button class="cart-checkout" type="button">Checkout</button>
        </div>
    </aside>
    <script>
        (() => {
            const storageKey = 'aurixCart';
            const drawer = document.querySelector('[data-cart-drawer]');
            const itemsNode = document.querySelector('[data-cart-items]');
            const subtotalNode = document.querySelector('[data-cart-subtotal]');
            const money = new Intl.NumberFormat('en-KE', { maximumFractionDigits: 0 });
            let cart = [];

            const escapeHtml = (value) => String(value)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');

            const readCart = () => {
                try {
                    const parsed = JSON.parse(localStorage.getItem(storageKey) || '[]');
                    cart = Array.isArray(parsed) ? parsed : [];
                } catch {
                    cart = [];
                }
            };

            const saveCart = () => {
                localStorage.setItem(storageKey, JSON.stringify(cart));
            };

            const openCart = () => {
                document.body.classList.add('cart-is-open');
                drawer?.setAttribute('aria-hidden', 'false');
            };

            const closeCart = () => {
                document.body.classList.remove('cart-is-open');
                drawer?.setAttribute('aria-hidden', 'true');
            };

            const renderCart = () => {
                if (!itemsNode || !subtotalNode) return;

                if (!cart.length) {
                    itemsNode.innerHTML = '<p class="cart-empty">Your cart is empty. Add a product and it will appear here.</p>';
                    subtotalNode.textContent = 'KSh 0';
                    return;
                }

                const subtotal = cart.reduce((sum, item) => sum + (Number(item.price) || 0) * item.qty, 0);
                subtotalNode.textContent = `KSh ${money.format(subtotal)}`;
                itemsNode.innerHTML = cart.map((item) => `
                    <article class="cart-item">
                        ${item.image ? `<img src="${item.image}" alt="">` : '<span class="cart-item-placeholder">No image</span>'}
                        <div>
                            <h3>${escapeHtml(item.name)}</h3>
                            <span class="cart-item-price">KSh ${money.format(Number(item.price) || 0)}</span>
                            <div class="cart-item-row">
                                <span class="cart-qty">
                                    <button type="button" data-cart-decrease="${item.id}" aria-label="Decrease quantity">−</button>
                                    <strong>${item.qty}</strong>
                                    <button type="button" data-cart-increase="${item.id}" aria-label="Increase quantity">+</button>
                                </span>
                                <button class="cart-remove" type="button" data-cart-remove="${item.id}">Remove</button>
                            </div>
                        </div>
                    </article>
                `).join('');
            };

            const addToCart = (button) => {
                const item = {
                    id: button.dataset.productId,
                    name: button.dataset.productName || 'Product',
                    price: Number(button.dataset.productPrice) || 0,
                    image: button.dataset.productImage || '',
                    qty: 1,
                };
                const existing = cart.find((cartItem) => cartItem.id === item.id);
                if (existing) {
                    existing.qty += 1;
                } else {
                    cart.push(item);
                }
                saveCart();
                renderCart();
                openCart();
            };

            document.addEventListener('click', (event) => {
                const target = event.target instanceof Element ? event.target : null;
                if (!target) return;

                const addButton = target.closest('[data-cart-add]');
                if (addButton) {
                    addToCart(addButton);
                    return;
                }

                if (target.closest('[data-cart-open]')) {
                    openCart();
                    return;
                }

                if (target.closest('[data-cart-close]')) {
                    closeCart();
                    return;
                }

                const increase = target.closest('[data-cart-increase]');
                if (increase) {
                    const item = cart.find((cartItem) => cartItem.id === increase.dataset.cartIncrease);
                    if (item) item.qty += 1;
                    saveCart();
                    renderCart();
                    return;
                }

                const decrease = target.closest('[data-cart-decrease]');
                if (decrease) {
                    const item = cart.find((cartItem) => cartItem.id === decrease.dataset.cartDecrease);
                    if (item) item.qty -= 1;
                    cart = cart.filter((cartItem) => cartItem.qty > 0);
                    saveCart();
                    renderCart();
                    return;
                }

                const remove = target.closest('[data-cart-remove]');
                if (remove) {
                    cart = cart.filter((cartItem) => cartItem.id !== remove.dataset.cartRemove);
                    saveCart();
                    renderCart();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') closeCart();
            });

            readCart();
            renderCart();
        })();
    </script>
</body>
</html>
