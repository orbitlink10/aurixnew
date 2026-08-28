@extends('layouts.public')

@section('title', 'Aurix Branding — Premium Branding & Printing in Kenya')
@section('meta_description', 'Aurix Branding provides professional corporate branding, custom apparel, embroidery, signage, promotional merchandise, and printed materials with reliable production and nationwide delivery across Kenya.')

@section('content')
    @php
        $whatsappPhone = '254700816670';
        $whatsappUrl = 'https://wa.me/'.$whatsappPhone.'?text='.rawurlencode('Hello Aurix Branding, I would like a quote.');
        $quoteUrl = route('public.quote');

        $heroSrc = $heroImage ?: asset('images/aurix-branding-collage.png');

        $services = [
            ['title' => 'Corporate Branding', 'text' => 'Complete brand identity for uniforms, stationery, and workplace visibility.', 'image' => 'images/aurix-branding-collage.png', 'href' => route('public.products.index', ['category' => 'corporate'])],
            ['title' => 'T-Shirt & Apparel Printing', 'text' => 'Custom tees, polos, and branded apparel for teams and events.', 'image' => 'images/aurix-tshirt-category.png', 'href' => route('public.products.index')],
            ['title' => 'Embroidery', 'text' => 'Durable, premium embroidery for uniforms, caps, and corporate wear.', 'image' => 'images/aurix-embroidery-production-collage.png', 'href' => route('public.embroidery')],
            ['title' => 'Promotional Merchandise', 'text' => 'Branded gifts and merchandise that keep your brand in front of customers.', 'image' => 'images/aurix-hoodie-category.png', 'href' => route('public.products.index')],
            ['title' => 'Signage & Large Format', 'text' => 'Outdoor signage, roll-up banners, and large format printing.', 'image' => 'images/aurix-design-categories.png', 'href' => route('public.products.index')],
            ['title' => 'Business Printing', 'text' => 'Business cards, stationery, and printed materials that build trust.', 'image' => 'images/aurix-business-cards.png', 'href' => route('public.products.index')],
        ];

        $portfolioFallback = [
            ['title' => 'Corporate Uniforms', 'image' => 'images/aurix-polo-category.png', 'href' => route('public.products.index', ['category' => 'corporate'])],
            ['title' => 'Embroidered Apparel', 'image' => 'images/aurix-embroidery-production-collage.png', 'href' => route('public.embroidery')],
            ['title' => 'Branded Apparel', 'image' => 'images/aurix-tshirt-category.png', 'href' => route('public.products.index')],
            ['title' => 'Branded Merchandise', 'image' => 'images/aurix-hoodie-category.png', 'href' => route('public.products.index')],
            ['title' => 'Signage & Banners', 'image' => 'images/aurix-design-categories.png', 'href' => route('public.products.index')],
            ['title' => 'Business Stationery', 'image' => 'images/aurix-business-cards.png', 'href' => route('public.products.index')],
        ];

        $portfolioItems = $portfolio && $portfolio->isNotEmpty()
            ? $portfolio->map(fn ($item) => [
                'title' => $item->name,
                'image' => $item->image_url ?: asset('images/aurix-branding-collage.png'),
                'href' => route('public.products.index'),
            ])->values()->all()
            : $portfolioFallback;
    @endphp

    {{-- Hero ------------------------------------------------------- --}}
    <section class="bg-white">
        <div class="container-x grid items-center gap-12 py-14 lg:grid-cols-2 lg:py-20">
            <div>
                <span class="eyebrow">Premium branding &amp; printing</span>
                <h1 class="mt-5 text-4xl font-bold leading-[1.05] tracking-tight text-ink sm:text-5xl lg:text-[3.4rem]">
                    Professional branding that makes your business stand out.
                </h1>
                <p class="mt-6 max-w-xl text-lg leading-relaxed text-ink-soft">
                    Aurix Branding helps businesses create professional apparel, signage, promotional merchandise, and printed materials with reliable production and nationwide delivery.
                </p>
                <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ $quoteUrl }}" class="btn btn-primary btn-lg">Request a Quote</a>
                    <a href="#work" class="btn btn-outline btn-lg">Explore Our Work</a>
                </div>
            </div>
            <div class="media media-4x3 media--cover rounded-2xl border border-line">
                @if(!empty($heroVideoEmbedUrl))
                    <iframe src="{{ $heroVideoEmbedUrl }}" title="Aurix Branding production video" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen style="width:100%;height:100%;border:0;"></iframe>
                @else
                    <img src="{{ $heroSrc }}" alt="Aurix Branding custom branding and printing work" width="1200" height="900" fetchpriority="high">
                @endif
            </div>
        </div>
    </section>

    {{-- Trust / value strip --------------------------------------- --}}
    <section class="border-y border-line bg-neutral">
        <div class="container-x grid grid-cols-2 gap-8 py-10 md:grid-cols-4">
            @foreach([
                ['Quality Branding', 'Sharp, durable production'],
                ['Fast Turnaround', 'Reliable delivery timelines'],
                ['Bulk & Custom Orders', 'From single pieces to large runs'],
                ['Nationwide Delivery', 'Serving all of Kenya'],
            ] as $item)
                <div class="flex items-start gap-4">
                    <span class="mt-1 inline-flex h-9 w-9 items-center justify-center rounded-full bg-accent-soft text-accent-deep">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <div>
                        <div class="font-semibold text-ink">{{ $item[0] }}</div>
                        <div class="text-sm text-ink-soft">{{ $item[1] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Services --------------------------------------------------- --}}
    <section id="services" class="section bg-white">
        <div class="container-x">
            <div class="section-head">
                <span class="eyebrow">What we do</span>
                <h2 class="section-title">Branding and printing services</h2>
                <p class="section-sub">Six core services, one dependable production partner for your brand.</p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($services as $service)
                    <a href="{{ $service['href'] }}" class="card group flex flex-col overflow-hidden transition-shadow hover:shadow-lg">
                        <div class="media media-4x3 media--cover">
                            <img src="{{ asset($service['image']) }}" alt="{{ $service['title'] }}" loading="lazy" width="800" height="600">
                        </div>
                        <div class="flex flex-1 flex-col p-6">
                            <h3 class="text-lg font-semibold text-ink">{{ $service['title'] }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-ink-soft">{{ $service['text'] }}</p>
                            <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-accent-deep">
                                Explore Service
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Featured categories ---------------------------------------- --}}
    @if($homepageCategories && $homepageCategories->isNotEmpty())
        <section class="section bg-cream">
            <div class="container-x">
                <div class="section-head">
                    <span class="eyebrow">Browse by category</span>
                    <h2 class="section-title">Featured branding categories</h2>
                    <p class="section-sub">Start from a category and request a tailored quotation.</p>
                </div>

                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
                    @foreach($homepageCategories as $category)
                        <a href="{{ route('public.products.index', ['category' => $category->slug]) }}" class="card group overflow-hidden text-center">
                            <div class="media media-square media--contain p-4">
                                @if($category->image_url)
                                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}" loading="lazy" width="400" height="400">
                                @else
                                    <img src="{{ asset('images/aurix-design-categories.png') }}" alt="{{ $category->name }}" loading="lazy" width="400" height="400">
                                @endif
                            </div>
                            <div class="px-3 pb-5">
                                <div class="text-sm font-semibold text-ink">{{ $category->name }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Portfolio / our work --------------------------------------- --}}
    <section id="work" class="section bg-white">
        <div class="container-x">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div class="section-head mb-0">
                    <span class="eyebrow">Our work</span>
                    <h2 class="section-title">Recent branding projects</h2>
                    <p class="section-sub">Visual proof of what we produce for businesses across Kenya.</p>
                </div>
                <a href="{{ $quoteUrl }}" class="btn btn-outline shrink-0">View Our Work</a>
            </div>

            <div class="mt-10 grid grid-cols-2 gap-4 lg:grid-cols-3" data-lightbox-gallery>
                @foreach($portfolioItems as $item)
                    <button type="button" class="media media-4x3 media--cover group relative overflow-hidden rounded-xl text-left" data-lightbox-trigger data-lightbox-src="{{ $item['image'] }}" data-lightbox-title="{{ $item['title'] }}">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" loading="lazy" width="800" height="600" class="transition-transform duration-300 group-hover:scale-105">
                        <span class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <span class="text-sm font-semibold text-white">{{ $item['title'] }}</span>
                        </span>
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Why Aurix Branding ----------------------------------------- --}}
    <section id="about" class="section bg-cream">
        <div class="container-x grid items-center gap-12 lg:grid-cols-2">
            <div class="media media-4x3 media--cover rounded-2xl border border-line">
                <img src="{{ asset('images/aurix-branding-collage.png') }}" alt="Aurix Branding production quality" loading="lazy" width="1200" height="900">
            </div>
            <div>
                <span class="eyebrow">Why Aurix Branding</span>
                <h2 class="section-title">A production partner you can trust</h2>
                <p class="mt-5 text-lg leading-relaxed text-ink-soft">
                    We combine clean design, careful material selection, and dependable production to deliver branding that feels premium and lasts. From corporates and SMEs to schools, events, and institutions.
                </p>
                <ul class="mt-7 grid gap-4">
                    @foreach([
                        'One point of contact from artwork to delivery.',
                        'Quotation-based pricing matched to your quantity and materials.',
                        'Quality checks on every order before dispatch.',
                        'Artwork and design support when you need it.',
                    ] as $point)
                        <li class="flex items-start gap-3">
                            <span class="mt-0.5 inline-flex h-6 w-6 flex-none items-center justify-center rounded-full bg-accent-soft text-accent-deep">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span class="text-ink-soft">{{ $point }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- How it works ------------------------------------------------ --}}
    <section class="section bg-white">
        <div class="container-x">
            <div class="section-head section-head--center">
                <span class="eyebrow">Simple process</span>
                <h2 class="section-title">How it works</h2>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach([
                    ['01', 'Share Your Requirements', 'Tell us what you need branded, quantities, and timeline.'],
                    ['02', 'Approve Design & Quote', 'We send a design proof and a tailored quotation.'],
                    ['03', 'We Produce Your Order', 'Your order is produced with careful quality control.'],
                    ['04', 'Pickup or Delivery', 'Collect in Nairobi or we deliver nationwide.'],
                ] as $step)
                    <div class="card p-6">
                        <div class="text-2xl font-bold text-accent">{{ $step[0] }}</div>
                        <h3 class="mt-3 text-base font-semibold text-ink">{{ $step[1] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-ink-soft">{{ $step[2] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Client trust ------------------------------------------------ --}}
    <section class="section bg-cream">
        <div class="container-x">
            <div class="section-head section-head--center">
                <span class="eyebrow">Who we serve</span>
                <h2 class="section-title">Trusted by businesses across Kenya</h2>
                <p class="section-sub">We handle branding and printing for organisations of every size and sector.</p>
            </div>

            <div class="flex flex-wrap justify-center gap-3">
                @foreach(['Corporates', 'SMEs', 'Schools', 'Events', 'Restaurants', 'Hotels', 'Institutions', 'Startups'] as $audience)
                    <span class="rounded-full border border-line bg-white px-5 py-2.5 text-sm font-semibold text-ink">{{ $audience }}</span>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Final CTA --------------------------------------------------- --}}
    <section id="contact" class="section bg-brand text-white">
        <div class="container-x text-center">
            <h2 class="mx-auto max-w-2xl text-3xl font-bold tracking-tight sm:text-4xl">Ready to bring your brand to life?</h2>
            <p class="mx-auto mt-5 max-w-2xl text-lg text-gray-300">
                Tell us what you're branding and we'll help you choose the right materials, printing method, and finishing.
            </p>
            <div class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <a href="{{ $quoteUrl }}" class="btn btn-accent btn-lg">Request a Quote</a>
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="btn btn-whatsapp btn-lg">WhatsApp Us</a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const triggers = document.querySelectorAll('[data-lightbox-trigger]');
            if (!triggers.length) return;

            const overlay = document.createElement('div');
            overlay.setAttribute('role', 'dialog');
            overlay.setAttribute('aria-modal', 'true');
            overlay.setAttribute('aria-label', 'Image viewer');
            overlay.style.cssText = 'position:fixed;inset:0;z-index:100;display:none;align-items:center;justify-content:center;background:rgba(17,24,39,0.9);padding:24px;';
            overlay.innerHTML = '<button data-lightbox-close aria-label="Close" style="position:absolute;top:16px;right:20px;color:#fff;font-size:2rem;line-height:1;background:none;border:0;cursor:pointer;">&times;</button><figure style="max-width:min(920px,100%);text-align:center;"><img data-lightbox-image src="" alt="" style="max-height:78vh;width:auto;max-width:100%;border-radius:12px;object-fit:contain;"><figcaption data-lightbox-caption style="color:#fff;margin-top:14px;font-size:1rem;font-weight:600;"></figcaption></figure>';
            document.body.appendChild(overlay);

            const image = overlay.querySelector('[data-lightbox-image]');
            const caption = overlay.querySelector('[data-lightbox-caption]');

            const open = (trigger) => {
                image.src = trigger.dataset.lightboxSrc;
                image.alt = trigger.dataset.lightboxTitle || '';
                caption.textContent = trigger.dataset.lightboxTitle || '';
                overlay.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            };

            const close = () => {
                overlay.style.display = 'none';
                document.body.style.overflow = '';
            };

            triggers.forEach((trigger) => trigger.addEventListener('click', () => open(trigger)));
            overlay.querySelector('[data-lightbox-close]').addEventListener('click', close);
            overlay.addEventListener('click', (event) => {
                if (event.target === overlay) close();
            });
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') close();
            });
        });
    </script>
@endpush
