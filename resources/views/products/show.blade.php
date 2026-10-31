@extends('layouts.taf')

@section('title', $product->name . ' — Aurix Branding')
@section('meta_description', $product->meta_description ?: Str::limit(strip_tags($product->description ?? ''), 155))
@section('canonical', route('public.products.show', ['product' => $product->slug]))

@push('head')
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "BreadcrumbList",
        "itemListElement": [
            {"@@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}"},
            {"@@type": "ListItem", "position": 2, "name": "Products", "item": "{{ route('public.products.index') }}"},
            {"@@type": "ListItem", "position": 3, "name": "{{ $product->name }}", "item": "{{ route('public.products.show', ['product' => $product->slug]) }}"}
        ]
    }
    </script>
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Product",
        "name": "{{ $product->name }}",
        "description": "{{ $product->meta_description ?: Str::limit(strip_tags($product->description ?? ''), 155) }}",
        "url": "{{ route('public.products.show', ['product' => $product->slug]) }}",
        "brand": {"@@type": "Brand", "name": "{{ config('app.name') }}"},
        @if($product->display_image_url)"image": "{{ $product->display_image_url }}",@endif
        "category": "{{ $product->category?->name ?: $product->category_name ?: 'Custom Branding' }}"
    }
    </script>
@endpush

@section('content')
    @php
        $categoryName = $product->category?->name ?: $product->category_name ?: 'Product';
        $subcategory = $product->subcategory_name ?: null;
        $summary = trim(strip_tags($product->meta_description ?: $product->description ?: 'Custom branding produced for professional brand visibility, events, and promotional campaigns.'));
        $minimumQty = (int) $product->quantity ?: null;
        $galleryImages = collect([$product->image_url])
            ->merge($product->relationLoaded('images') ? $product->images->pluck('image_url') : [])
            ->filter()
            ->unique()
            ->values();

        $contact = \Illuminate\Support\Facades\Schema::hasTable('site_settings')
            ? \App\Models\SiteSetting::contactSettings()
            : \App\Models\SiteSetting::defaultContactSettings();
        $whatsappPhone = preg_replace('/\D+/', '', $contact['whatsapp_phone'] ?? '254700816670') ?: '254700816670';
        $whatsappMessage = 'Hello Aurix Branding, I would like a quotation for '.$product->name.'. Quantity: [QUANTITY].';
        $whatsappUrl = 'https://wa.me/'.$whatsappPhone.'?text='.rawurlencode($whatsappMessage);
        $quoteUrl = route('public.quote', ['product' => $product->name]);

        $faqs = [
            ['q' => 'How do I get a quotation for '.$product->name.'?', 'a' => 'Click "Request a Quote" or message us on WhatsApp with your quantity and customization. We respond with a tailored quotation.'],
            ['q' => 'Do you support bulk orders?', 'a' => 'Yes. Bulk orders are quoted based on quantity, material, printing method, and finishing.'],
            ['q' => 'Can I order before my artwork is ready?', 'a' => 'Yes. Send your details and our design team can help you finalize artwork after quote confirmation.'],
            ['q' => 'Do you deliver nationwide?', 'a' => 'Yes. We deliver across Kenya with pickup available in Nairobi.'],
        ];
    @endphp

    <section class="taf-page-hero">
        <div class="taf-wrap">
            <nav class="taf-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Home</a><span aria-hidden="true">/</span><a href="{{ route('public.products.index') }}">Products</a><span aria-hidden="true">/</span><span>{{ $product->name }}</span>
            </nav>
        </div>
    </section>

    <section class="taf-section" style="padding-top:24px;">
        <div class="taf-wrap">
            <div style="display:grid;grid-template-columns:minmax(0,1fr) minmax(340px,0.8fr);gap:34px;align-items:start;">
                <div>
                    <div class="taf-content-card" style="padding:18px;">
                        <img id="productMainImage" src="{{ $galleryImages->first() ?: asset('images/aurix-branding-collage.png') }}" alt="{{ $product->name }}" width="800" height="800" fetchpriority="high" style="width:100%;aspect-ratio:1/1;object-fit:contain;border-radius:10px;">
                    </div>
                    @if($galleryImages->count() > 1)
                        <div style="display:flex;gap:10px;margin-top:14px;overflow-x:auto;padding-bottom:4px;">
                            @foreach($galleryImages as $imageUrl)
                                <button type="button" data-gallery-thumb data-gallery-src="{{ $imageUrl }}" aria-label="View image {{ $loop->iteration }}" style="flex:0 0 84px;width:84px;height:84px;border:2px solid {{ $loop->first ? 'var(--taf-gold)' : 'var(--taf-line)' }};border-radius:10px;background:#fff;padding:4px;cursor:pointer;">
                                    <img src="{{ $imageUrl }}" alt="{{ $product->name }} thumbnail {{ $loop->iteration }}" loading="lazy" style="width:100%;height:100%;object-fit:contain;">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="taf-content-card">
                    <span class="taf-category-kicker">{{ $categoryName }}</span>
                    <h1 style="margin:12px 0 14px;font-size:clamp(1.8rem,3vw,2.6rem);line-height:1.1;">{{ $product->name }}</h1>
                    <p style="color:var(--taf-muted);line-height:1.7;">{{ Str::limit($summary, 220) }}</p>

                    <dl style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;margin-top:20px;">
                        <div style="border:1px solid var(--taf-line);border-radius:10px;padding:12px;">
                            <dt style="font-size:12px;font-weight:800;color:var(--taf-muted);">Minimum Qty</dt>
                            <dd style="margin:4px 0 0;font-weight:900;">{{ $minimumQty ? $minimumQty.' pieces' : 'No minimum' }}</dd>
                        </div>
                        <div style="border:1px solid var(--taf-line);border-radius:10px;padding:12px;">
                            <dt style="font-size:12px;font-weight:800;color:var(--taf-muted);">Category</dt>
                            <dd style="margin:4px 0 0;font-weight:900;">{{ $categoryName }}</dd>
                        </div>
                    </dl>

                    <div style="margin-top:24px;display:flex;flex-direction:column;gap:12px;">
                        <a href="{{ $quoteUrl }}" class="taf-primary-btn" style="width:100%;">Request a Quote</a>
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="taf-link-btn" style="width:100%;">WhatsApp Us</a>
                    </div>
                    <p style="margin-top:14px;font-size:13px;color:var(--taf-muted);">Pricing is quotation-based depending on quantity, material, printing method, finishing, and delivery.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="taf-section" style="padding-top:20px;">
        <div class="taf-wrap">
            <div style="display:grid;grid-template-columns:minmax(0,1fr) 320px;gap:28px;align-items:start;">
                <div class="taf-prose" style="max-width:760px;">
                    <h2>Overview</h2>
                    @if($product->description)
                        {!! $product->description !!}
                    @else
                        <p>{{ $product->name }} is produced for professional brand visibility, customer engagement, events, retail packaging, and promotional campaigns. Our team will guide the right material, finish, and delivery plan for your project.</p>
                    @endif

                    <h2>Artwork requirements</h2>
                    <ul>
                        <li>Upload your finished artwork, a logo, or request a fresh design.</li>
                        <li>We check sizing, resolution, placement, and bleed before production.</li>
                        <li>Accepted files: PDF, PNG, JPG, SVG, and AI.</li>
                    </ul>

                    <h2>Frequently asked questions</h2>
                    @foreach($faqs as $faq)
                        <h3>{{ $faq['q'] }}</h3>
                        <p>{{ $faq['a'] }}</p>
                    @endforeach
                </div>

                <aside>
                    <div class="taf-content-card">
                        <h2 style="margin-top:0;font-size:18px;">Specifications</h2>
                        <dl style="margin:0;font-size:14px;">
                            @foreach([
                                'Product' => $product->name,
                                'Category' => $categoryName,
                                'Subcategory' => ($subcategory ?: 'Custom print'),
                                'Minimum Quantity' => ($minimumQty ? $minimumQty.' pieces' : 'No minimum'),
                                'Artwork' => 'Upload or design online',
                                'Delivery' => 'Nationwide',
                            ] as $label => $value)
                                <div style="display:flex;justify-content:space-between;gap:12px;padding:10px 0;border-bottom:1px solid var(--taf-line);">
                                    <dt style="color:var(--taf-muted);">{{ $label }}</dt>
                                    <dd style="margin:0;text-align:right;font-weight:700;">{{ $value }}</dd>
                                </div>
                            @endforeach
                        </dl>
                        <a href="{{ $quoteUrl }}" class="taf-primary-btn" style="width:100%;margin-top:16px;">Request a Quote</a>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    @if($relatedProducts && $relatedProducts->isNotEmpty())
        <section class="taf-section">
            <div class="taf-wrap">
                <div class="taf-category-head">
                    <div><span class="taf-category-kicker">Related</span><h2>Related products</h2></div>
                </div>
                <div class="taf-product-grid">
                    @foreach($relatedProducts as $related)
                        <a href="{{ route('public.products.show', ['product' => $related->slug]) }}" class="taf-product-card">
                            <span class="taf-product-media">
                                <img src="{{ $related->display_image_url ?: asset('images/aurix-branding-collage.png') }}" alt="{{ $related->name }}" loading="lazy" width="400" height="400">
                            </span>
                            <span class="taf-product-info">
                                <strong>{{ $related->name }}</strong>
                                <span class="taf-product-quote">Request Quote</span>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mainImage = document.getElementById('productMainImage');
            document.querySelectorAll('[data-gallery-thumb]').forEach((thumb) => {
                thumb.addEventListener('click', () => {
                    if (!mainImage) return;
                    mainImage.src = thumb.dataset.gallerySrc;
                });
            });
        });
    </script>
@endpush
