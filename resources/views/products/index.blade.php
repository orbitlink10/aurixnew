<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | {{ config('app.name') }}</title>
    <meta name="description" content="Browse Aurix Branding products for printing, signage, branded apparel, promotional items, and business materials.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: #f5f7fb;
            color: #0f172a;
            font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        a { color: inherit; text-decoration: none; }
        .site-header {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
        }
        .header-inner,
        .products-shell {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
        }
        .header-inner {
            min-height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }
        .brand {
            font-size: 1.25rem;
            font-weight: 800;
        }
        .back-link {
            color: #2563eb;
            font-weight: 700;
        }
        .products-shell {
            padding: 34px 0 48px;
        }
        .page-head {
            display: grid;
            grid-template-columns: 1fr minmax(260px, 420px);
            gap: 18px;
            align-items: end;
            margin-bottom: 22px;
        }
        .page-head h1 {
            margin: 0 0 8px;
            font-size: clamp(2rem, 4vw, 3.2rem);
            line-height: 1.05;
        }
        .page-head p {
            margin: 0;
            color: #64748b;
        }
        .search-form {
            display: flex;
            gap: 8px;
        }
        .search-form input {
            min-width: 0;
            flex: 1;
            border: 1px solid #dbe3ef;
            border-radius: 8px;
            padding: 12px 14px;
            font: inherit;
        }
        .search-form button,
        .category-link,
        .reset-link {
            border-radius: 8px;
            font-weight: 700;
        }
        .search-form button {
            border: 0;
            background: #2563eb;
            color: #ffffff;
            padding: 0 18px;
            cursor: pointer;
        }
        .category-strip {
            display: flex;
            gap: 10px;
            margin-bottom: 24px;
            overflow-x: auto;
            padding-bottom: 4px;
        }
        .category-link,
        .reset-link {
            display: inline-flex;
            flex: 0 0 auto;
            border: 1px solid #dbe3ef;
            background: #ffffff;
            color: #334155;
            padding: 9px 12px;
            font-size: 0.9rem;
        }
        .category-link.is-active,
        .reset-link {
            border-color: #2563eb;
            color: #2563eb;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }
        .product-card {
            display: flex;
            min-height: 100%;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
        }
        .product-media {
            aspect-ratio: 4 / 3;
            display: grid;
            place-items: center;
            background: #f8fafc;
        }
        .product-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .image-empty {
            color: #94a3b8;
            font-size: 0.85rem;
            font-weight: 700;
        }
        .product-body {
            display: flex;
            flex: 1;
            flex-direction: column;
            padding: 15px;
        }
        .kicker {
            color: #2563eb;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
        }
        .product-body h2 {
            margin: 8px 0;
            font-size: 1rem;
            line-height: 1.28;
        }
        .product-summary {
            margin: 0 0 14px;
            color: #64748b;
            font-size: 0.88rem;
            line-height: 1.55;
        }
        .product-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: auto;
        }
        .price {
            font-weight: 800;
        }
        .view-link {
            color: #2563eb;
            font-size: 0.88rem;
            font-weight: 800;
        }
        .empty-state {
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
            background: #ffffff;
            padding: 34px;
            text-align: center;
        }
        .empty-state h2 {
            margin: 0 0 8px;
        }
        .empty-state p {
            margin: 0 0 16px;
            color: #64748b;
        }
        .pagination-wrap {
            margin-top: 24px;
        }
        .pagination-wrap nav {
            display: flex;
            justify-content: center;
        }
        @media (max-width: 980px) {
            .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        @media (max-width: 680px) {
            .page-head {
                grid-template-columns: 1fr;
            }
            .search-form {
                flex-direction: column;
            }
            .search-form button {
                min-height: 46px;
            }
            .product-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a href="{{ url('/') }}" class="brand">Aurix Branding</a>
            <a href="{{ url('/') }}" class="back-link">Back to Home</a>
        </div>
    </header>

    <main class="products-shell">
        <div class="page-head">
            <div>
                <h1>Products</h1>
                <p>Browse available print, signage, apparel, and promotional products.</p>
            </div>
            <form action="{{ route('public.products.index') }}" method="GET" class="search-form">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Search products">
                <button type="submit">Search</button>
            </form>
        </div>

        @if($categories->count())
            <nav class="category-strip" aria-label="Product categories">
                <a href="{{ route('public.products.index', request('q') ? ['q' => request('q')] : []) }}" class="category-link {{ request('category') ? '' : 'is-active' }}">All products</a>
                @foreach($categories as $category)
                    <a
                        href="{{ route('public.products.index', array_filter(['category' => $category->slug, 'q' => request('q')])) }}"
                        class="category-link {{ request('category') === $category->slug ? 'is-active' : '' }}"
                    >
                        {{ $category->name }} ({{ $category->products_count }})
                    </a>
                @endforeach
            </nav>
        @endif

        @if(request('q') || request('category'))
            <p><a href="{{ route('public.products.index') }}" class="reset-link">Clear filters</a></p>
        @endif

        @forelse($products as $product)
            @if($loop->first)
                <div class="product-grid">
            @endif
                <a href="{{ route('public.products.show', ['product' => $product->slug]) }}" class="product-card">
                    <div class="product-media">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        @else
                            <div class="image-empty">No image</div>
                        @endif
                    </div>
                    <div class="product-body">
                        <span class="kicker">{{ $product->category?->name ?: $product->category_name ?: 'Product' }}</span>
                        <h2>{{ $product->name }}</h2>
                        @if($product->description)
                            <p class="product-summary">{{ \Illuminate\Support\Str::limit(strip_tags($product->description), 95) }}</p>
                        @endif
                        <div class="product-footer">
                            <span class="price">KES {{ number_format((float) $product->price, 2) }}</span>
                            <span class="view-link">View</span>
                        </div>
                    </div>
                </a>
            @if($loop->last)
                </div>
            @endif
        @empty
            <div class="empty-state">
                <h2>No products found</h2>
                <p>Try clearing filters or adding active products from the dashboard.</p>
                <a href="{{ route('public.products.index') }}" class="reset-link">View all products</a>
            </div>
        @endforelse

        @if($products->hasPages())
            <div class="pagination-wrap">{{ $products->links() }}</div>
        @endif
    </main>
</body>
</html>
