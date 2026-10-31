@extends('layouts.taf')

@section('title', 'Custom Apparel & Branded Products | Aurix Branding')
@section('meta_description', 'Browse Aurix Branding custom apparel, uniforms, embroidery, signage, and promotional products in Nairobi, Kenya. Request a tailored quote for your branding project.')

@if(request('q'))
    @section('robots', 'noindex, follow')
@endif

@section('content')
    <section class="taf-page-hero">
        <div class="taf-wrap">
            <nav class="taf-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Home</a><span aria-hidden="true">/</span><span>Products</span>
            </nav>
            <span class="taf-eyebrow">Our catalogue</span>
            <h1>Custom Apparel &amp; Branded Products</h1>
            <p>Browse what we produce. Pricing is quotation-based — request a quote and we'll tailor it to your quantity, material, and finishing.</p>
        </div>
    </section>

    <section class="taf-section">
        <div class="taf-wrap">
            <form action="{{ route('public.products.index') }}" method="GET" class="taf-search" style="max-width:640px;margin-bottom:28px;" role="search">
                <input name="q" type="search" value="{{ request('q') }}" placeholder="Search products and services" aria-label="Search products">
                <button type="submit" aria-label="Search">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 6 16.65a7.5 7.5 0 0 0 10.65 0Z"/></svg>
                </button>
            </form>

            @if($categories->isNotEmpty())
                <div class="taf-category-row" style="margin-bottom:28px;">
                    <a href="{{ route('public.products.index') }}" class="taf-category-card" style="border:1px solid var(--taf-line);border-radius:10px;padding:12px 16px;{{ !request('category') ? 'background:var(--taf-gold-light);' : '' }}">All categories</a>
                    @foreach($categories as $category)
                        <a href="{{ route('public.products.index', ['category' => $category->slug]) }}" class="taf-category-card" style="border:1px solid var(--taf-line);border-radius:10px;padding:12px 16px;{{ request('category') === $category->slug ? 'background:var(--taf-gold-light);' : '' }}">{{ $category->name }}</a>
                    @endforeach
                </div>
            @endif

            <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;">
                <p style="color:var(--taf-muted);font-size:14px;margin:0;">{{ $products->total() }} {{ $products->total() == 1 ? 'product' : 'products' }}</p>
                <form action="{{ route('public.products.index') }}" method="GET" style="display:flex;align-items:center;gap:10px;">
                    @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif
                    @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                    <label for="sort" style="font-size:14px;font-weight:700;">Sort by</label>
                    <select id="sort" name="sort" onchange="this.form.submit()" style="border:1px solid var(--taf-line);border-radius:10px;padding:10px 12px;font:inherit;">
                        <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Popular</option>
                        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                    </select>
                </form>
            </div>

            <div class="taf-product-grid">
                @forelse($products as $product)
                    @php
                        $categoryLabel = $product->category?->name ?: $product->category_name ?: $product->subcategory_name ?: 'Branding';
                    @endphp
                    <a href="{{ route('public.products.show', ['product' => $product->slug]) }}" class="taf-product-card">
                        <span class="taf-product-media">
                            <img src="{{ $product->display_image_url ?: asset('images/aurix-branding-collage.png') }}" alt="{{ $product->name }}" loading="lazy" width="400" height="400">
                        </span>
                        <span class="taf-product-info">
                            <span class="taf-product-quote">{{ $categoryLabel }}</span>
                            <strong>{{ $product->name }}</strong>
                            <span class="taf-product-quote">Request Quote</span>
                        </span>
                    </a>
                @empty
                    <p class="taf-dashboard-empty" style="grid-column:1/-1;">No products found. Try a different search term or category.</p>
                @endforelse
            </div>

            @if($products->hasPages())
                <div style="margin-top:32px;">{{ $products->links() }}</div>
            @endif
        </div>
    </section>
@endsection
