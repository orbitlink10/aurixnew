@extends('layouts.public')

@section('title', 'Products — Aurix Branding')
@section('meta_description', 'Explore Aurix Branding products for corporate branding, custom apparel, embroidery, signage, promotional merchandise, and business printing. Request a tailored quote.')

@section('content')
    <section class="section-tight bg-white">
        <div class="container-x">
            <div class="section-head">
                <span class="eyebrow">Our catalogue</span>
                <h1 class="section-title">Products &amp; Services</h1>
                <p class="section-sub">Browse what we produce. Pricing is quotation-based — request a quote and we'll tailor it to your quantity, material, and finishing.</p>
            </div>

            <form action="{{ route('public.products.index') }}" method="GET" class="mb-8 flex flex-col gap-3 sm:flex-row">
                <div class="relative flex-1">
                    <svg class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-ink-faint" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Search products and services" class="field-control !pl-12">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

            <div class="grid gap-8 lg:grid-cols-[260px_1fr]">
                <aside>
                    <div class="card p-5">
                        <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-ink">Categories</h2>
                        <div class="grid gap-1">
                            <a href="{{ route('public.products.index') }}" class="rounded-md px-3 py-2 text-sm font-medium {{ !request('category') || request('category') === 'all-categories' ? 'bg-neutral text-ink' : 'text-ink-soft hover:bg-neutral' }}">All categories</a>
                            @foreach($categories as $category)
                                <a href="{{ route('public.products.index', ['category' => $category->slug]) }}" class="flex items-center justify-between rounded-md px-3 py-2 text-sm font-medium {{ request('category') === $category->slug ? 'bg-neutral text-ink' : 'text-ink-soft hover:bg-neutral' }}">
                                    <span>{{ $category->name }}</span>
                                    <span class="text-xs text-ink-faint">{{ $category->products_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </aside>

                <section>
                    <div class="mb-6 flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center">
                        <p class="text-sm text-ink-soft">{{ $products->total() }} {{ $products->total() == 1 ? 'product' : 'products' }}</p>
                        <form action="{{ route('public.products.index') }}" method="GET" class="flex items-center gap-3">
                            @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif
                            @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                            <label class="text-sm font-medium text-ink-soft">Sort by</label>
                            <select name="sort" class="field-control !min-h-0 !py-2" onchange="this.form.submit()">
                                <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Popular</option>
                                <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                            </select>
                        </form>
                    </div>

                    @forelse($products as $product)
                        @if($loop->first)<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">@endif
                            @php
                                $categoryLabel = $product->category?->name ?: $product->category_name ?: $product->subcategory_name ?: 'Branding';
                            @endphp
                            <article class="card group flex flex-col overflow-hidden">
                                <a href="{{ route('public.products.show', ['product' => $product->slug]) }}" class="media media-square media--contain p-4">
                                    @if($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy" width="500" height="500">
                                    @else
                                        <img src="{{ asset('images/aurix-branding-collage.png') }}" alt="{{ $product->name }}" loading="lazy" width="500" height="500">
                                    @endif
                                </a>
                                <div class="flex flex-1 flex-col p-5">
                                    <span class="text-xs font-semibold uppercase tracking-wider text-accent-deep">{{ $categoryLabel }}</span>
                                    <h2 class="mt-1.5 text-base font-semibold leading-snug text-ink">
                                        <a href="{{ route('public.products.show', ['product' => $product->slug]) }}" class="hover:text-accent-deep">{{ $product->name }}</a>
                                    </h2>
                                    <a href="{{ route('public.quote', ['product' => $product->name]) }}" class="btn btn-outline btn-sm mt-4 self-start">Request Quote</a>
                                </div>
                            </article>
                        @if($loop->last)</div>@endif
                    @empty
                        <div class="card p-12 text-center">
                            <h2 class="text-xl font-semibold text-ink">No products found</h2>
                            <p class="mt-2 text-ink-soft">Try a different search term or category.</p>
                        </div>
                    @endforelse

                    @if($products->hasPages())
                        <div class="mt-8">{{ $products->links() }}</div>
                    @endif
                </section>
            </div>
        </div>
    </section>
@endsection
