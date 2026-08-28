@extends('layouts.public')

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
        @if($product->image_url)"image": "{{ $product->image_url }}",@endif
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

        $whatsappPhone = '254700816670';
        $whatsappMessage = 'Hello Aurix Branding, I would like a quotation for '.$product->name.'. Quantity: [QUANTITY].';
        $whatsappUrl = 'https://wa.me/'.$whatsappPhone.'?text='.rawurlencode($whatsappMessage);
        $quoteUrl = route('public.quote', ['product' => $product->name]);

        $faqs = [
            ['q' => 'How do I get a quotation?', 'a' => 'Click "Request a Quote" or message us on WhatsApp with your product, quantity, and any customization. We respond with a tailored quotation.'],
            ['q' => 'Do you support bulk orders?', 'a' => 'Yes. Bulk orders are quoted based on quantity, material, printing method, and finishing.'],
            ['q' => 'Can I order before my artwork is ready?', 'a' => 'Yes. Send your details and our design team can help you finalize artwork after quote confirmation.'],
            ['q' => 'Do you deliver nationwide?', 'a' => 'Yes. We deliver across Kenya with pickup available in Nairobi.'],
        ];
    @endphp

    <section class="section-tight bg-white">
        <div class="container-x">
            <nav class="mb-8 flex flex-wrap items-center gap-2 text-sm text-ink-soft" aria-label="Breadcrumb">
                <a href="{{ url('/') }}" class="hover:text-ink">Home</a>
                <span aria-hidden="true">/</span>
                <a href="{{ route('public.products.index') }}" class="hover:text-ink">Products</a>
                <span aria-hidden="true">/</span>
                <span class="text-ink">{{ $product->name }}</span>
            </nav>

            <div class="grid gap-10 lg:grid-cols-2">
                {{-- Gallery ----------------------------------------- --}}
                <div>
                    <div class="media media-square media--contain overflow-hidden rounded-2xl border border-line bg-white p-6">
                        <img id="productMainImage" src="{{ $galleryImages->first() ?: asset('images/aurix-branding-collage.png') }}" alt="{{ $product->name }}" width="800" height="800" fetchpriority="high">
                    </div>
                    @if($galleryImages->count() > 1)
                        <div class="mt-4 flex gap-3 overflow-x-auto pb-1">
                            @foreach($galleryImages as $imageUrl)
                                <button type="button" class="media media-square media--contain h-20 w-20 flex-none overflow-hidden rounded-lg border-2 {{ $loop->first ? 'border-accent' : 'border-line' }} bg-white p-1" data-gallery-thumb data-gallery-src="{{ $imageUrl }}" aria-label="View image {{ $loop->iteration }}">
                                    <img src="{{ $imageUrl }}" alt="{{ $product->name }} thumbnail {{ $loop->iteration }}" loading="lazy">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Details ----------------------------------------- --}}
                <div>
                    <span class="eyebrow">{{ $categoryName }}</span>
                    <h1 class="mt-4 text-3xl font-bold tracking-tight text-ink sm:text-4xl">{{ $product->name }}</h1>
                    <p class="mt-4 leading-relaxed text-ink-soft">{{ Str::limit($summary, 220) }}</p>

                    <dl class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3">
                        <div class="card p-4">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-ink-faint">Minimum Qty</dt>
                            <dd class="mt-1 font-semibold text-ink">{{ $minimumQty ? $minimumQty.' pieces' : 'No minimum' }}</dd>
                        </div>
                        <div class="card p-4">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-ink-faint">Category</dt>
                            <dd class="mt-1 font-semibold text-ink">{{ $categoryName }}</dd>
                        </div>
                        <div class="card p-4">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-ink-faint">Delivery</dt>
                            <dd class="mt-1 font-semibold text-ink">Nationwide</dd>
                        </div>
                    </dl>

                    <div class="mt-6">
                        <h2 class="text-sm font-semibold text-ink">Available customization</h2>
                        <ul class="mt-3 grid gap-2 sm:grid-cols-2">
                            @foreach(['Sizes & quantities', 'Printing method', 'Material & finishing', 'Design & artwork support'] as $option)
                                <li class="flex items-center gap-2 text-sm text-ink-soft">
                                    <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-accent-soft text-accent-deep">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                                    </span>
                                    {{ $option }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ $quoteUrl }}" class="btn btn-primary btn-lg flex-1">Request a Quote</a>
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="btn btn-whatsapp btn-lg flex-1">WhatsApp Us</a>
                    </div>
                    <p class="mt-3 text-sm text-ink-faint">Pricing is quotation-based depending on quantity, material, printing method, finishing, and delivery.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Long-form content ------------------------------------------- --}}
    <section class="section-tight bg-cream">
        <div class="container-x grid gap-8 lg:grid-cols-[1fr_320px]">
            <div class="space-y-8">
                <div class="card p-6 sm:p-8">
                    <h2 class="text-2xl font-bold text-ink">Overview</h2>
                    <div class="prose-clean mt-4">
                        @if($product->description)
                            {!! $product->description !!}
                        @else
                            <p>{{ $product->name }} is produced for professional brand visibility, customer engagement, events, retail packaging, and promotional campaigns. Our team will guide the right material, finish, and delivery plan for your project.</p>
                        @endif
                    </div>
                </div>

                <div class="card p-6 sm:p-8">
                    <h2 class="text-2xl font-bold text-ink">Artwork requirements</h2>
                    <ul class="mt-4 grid gap-3 text-ink-soft">
                        <li class="flex gap-3"><span class="mt-1 text-accent-deep">&#8226;</span>Upload your finished artwork, a logo, or request a fresh design.</li>
                        <li class="flex gap-3"><span class="mt-1 text-accent-deep">&#8226;</span>We check sizing, resolution, placement, and bleed before production.</li>
                        <li class="flex gap-3"><span class="mt-1 text-accent-deep">&#8226;</span>Accepted files: PDF, PNG, JPG, SVG, and AI.</li>
                    </ul>
                </div>

                <div class="card p-6 sm:p-8">
                    <h2 class="text-2xl font-bold text-ink">Production process</h2>
                    <ol class="mt-4 grid gap-3">
                        @foreach(['Share requirements', 'Approve design & quote', 'We produce your order', 'Pickup or delivery'] as $index => $step)
                            <li class="flex items-start gap-3">
                                <span class="inline-flex h-7 w-7 flex-none items-center justify-center rounded-full bg-brand text-sm font-semibold text-white">{{ $index + 1 }}</span>
                                <span class="pt-0.5 text-ink-soft">{{ $step }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>

                <div class="card p-6 sm:p-8">
                    <h2 class="text-2xl font-bold text-ink">Frequently asked questions</h2>
                    <div class="mt-4 divide-y divide-line">
                        @foreach($faqs as $faq)
                            <details class="group py-4">
                                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-ink">
                                    {{ $faq['q'] }}
                                    <span class="text-accent-deep transition-transform group-open:rotate-45">+</span>
                                </summary>
                                <p class="mt-3 text-ink-soft">{{ $faq['a'] }}</p>
                            </details>
                        @endforeach
                    </div>
                </div>
            </div>

            <aside>
                <div class="card p-6">
                    <h2 class="text-base font-bold text-ink">Specifications</h2>
                    <dl class="mt-4 divide-y divide-line text-sm">
                        @foreach([
                            'Product' => $product->name,
                            'Category' => $categoryName,
                            'Subcategory' => ($subcategory ?: 'Custom print'),
                            'Minimum Quantity' => ($minimumQty ? $minimumQty.' pieces' : 'No minimum'),
                            'Artwork' => 'Upload or design online',
                            'Delivery' => 'Nationwide',
                        ] as $label => $value)
                            <div class="flex items-start justify-between gap-4 py-3">
                                <dt class="text-ink-faint">{{ $label }}</dt>
                                <dd class="text-right font-medium text-ink">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>

                <div class="card mt-6 p-6 bg-brand text-white">
                    <h2 class="text-lg font-bold">Need a quote?</h2>
                    <p class="mt-2 text-sm text-gray-300">Share your requirements and we'll send a tailored quotation.</p>
                    <a href="{{ $quoteUrl }}" class="btn btn-accent btn-sm mt-4 w-full">Request a Quote</a>
                </div>
            </aside>
        </div>
    </section>

    {{-- Related products -------------------------------------------- --}}
    @if($relatedProducts && $relatedProducts->isNotEmpty())
        <section class="section-tight bg-white">
            <div class="container-x">
                <div class="section-head">
                    <span class="eyebrow">Related</span>
                    <h2 class="section-title">Related products</h2>
                </div>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($relatedProducts as $related)
                        <article class="card group flex flex-col overflow-hidden">
                            <a href="{{ route('public.products.show', ['product' => $related->slug]) }}" class="media media-square media--contain p-4">
                                <img src="{{ $related->image_url ?: asset('images/aurix-branding-collage.png') }}" alt="{{ $related->name }}" loading="lazy" width="500" height="500">
                            </a>
                            <div class="flex flex-1 flex-col p-5">
                                <h3 class="text-sm font-semibold leading-snug text-ink">
                                    <a href="{{ route('public.products.show', ['product' => $related->slug]) }}" class="hover:text-accent-deep">{{ $related->name }}</a>
                                </h3>
                                <a href="{{ route('public.quote', ['product' => $related->name]) }}" class="btn btn-outline btn-sm mt-4 self-start">Request Quote</a>
                            </div>
                        </article>
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
                    document.querySelectorAll('[data-gallery-thumb]').forEach((item) => item.classList.remove('border-accent'));
                    thumb.classList.add('border-accent');
                });
            });
        });
    </script>
@endpush
