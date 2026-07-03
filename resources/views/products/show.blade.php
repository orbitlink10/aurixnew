<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | {{ config('app.name') }}</title>
    <meta name="description" content="{{ $product->meta_description ?: Str::limit(strip_tags($product->description ?? ''), 155) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: #f4f6fb;
            color: #0f172a;
            font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        .site-header {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
        }
        .header-inner {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
            min-height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }
        .brand {
            color: #0f172a;
            font-size: 1.25rem;
            font-weight: 700;
            text-decoration: none;
        }
        .back-link {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
        }
        .product-shell {
            width: min(1180px, calc(100% - 32px));
            margin: 32px auto;
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(320px, 0.8fr);
            gap: 28px;
            align-items: start;
        }
        .product-media,
        .product-panel {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 18px 32px rgba(15, 23, 42, 0.08);
        }
        .product-media {
            min-height: 420px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 18px;
        }
        .product-media img {
            width: 100%;
            height: 100%;
            max-height: 560px;
            object-fit: contain;
            border-radius: 10px;
        }
        .image-empty {
            width: 100%;
            min-height: 360px;
            display: grid;
            place-items: center;
            color: #94a3b8;
            background: #f8fafc;
            border-radius: 10px;
            font-weight: 600;
        }
        .product-panel {
            padding: 26px;
        }
        .kicker {
            display: inline-flex;
            border-radius: 999px;
            background: #e8f0ff;
            color: #1d4ed8;
            padding: 6px 12px;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        h1 {
            margin: 14px 0 12px;
            font-size: clamp(2rem, 4vw, 3.4rem);
            line-height: 1.06;
            letter-spacing: 0;
        }
        .price {
            color: #0f172a;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 0 18px;
        }
        .marked-price {
            color: #94a3b8;
            font-size: 1rem;
            font-weight: 500;
            margin-left: 8px;
            text-decoration: line-through;
        }
        .meta-list {
            display: grid;
            gap: 10px;
            margin: 18px 0;
            padding: 0;
            list-style: none;
        }
        .meta-list li {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            border-bottom: 1px dashed #e2e8f0;
            padding-bottom: 10px;
            color: #64748b;
        }
        .meta-list strong {
            color: #0f172a;
            font-weight: 600;
        }
        .description {
            margin-top: 26px;
            color: #334155;
            line-height: 1.75;
        }
        .description :first-child { margin-top: 0; }
        .cta {
            display: inline-flex;
            justify-content: center;
            margin-top: 18px;
            border-radius: 8px;
            background: #2563eb;
            color: #ffffff;
            padding: 12px 18px;
            text-decoration: none;
            font-weight: 700;
        }
        @media (max-width: 860px) {
            .product-shell {
                grid-template-columns: 1fr;
            }
            .product-media {
                min-height: 280px;
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

    <main class="product-shell">
        <section class="product-media">
            @if($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
            @else
                <div class="image-empty">No product image</div>
            @endif
        </section>

        <section class="product-panel">
            <span class="kicker">{{ $product->category_name ?: 'Product' }}</span>
            <h1>{{ $product->name }}</h1>
            <p class="price">
                KES {{ number_format((float) $product->price, 2) }}
                @if($product->marked_price)
                    <span class="marked-price">KES {{ number_format((float) $product->marked_price, 2) }}</span>
                @endif
            </p>

            <ul class="meta-list">
                <li><span>Availability</span><strong>{{ $product->is_active ? 'Available' : 'Inactive' }}</strong></li>
                <li><span>Quantity</span><strong>{{ $product->quantity ?? 0 }}</strong></li>
                <li><span>Subcategory</span><strong>{{ $product->subcategory_name ?: 'Not set' }}</strong></li>
            </ul>

            <a href="{{ url('/#quote') }}" class="cta">Request Quote</a>
        </section>

        @if($product->description)
            <section class="product-panel description" style="grid-column: 1 / -1;">
                {!! $product->description !!}
            </section>
        @endif
    </main>
</body>
</html>
