@extends('layouts.public')

@section('title', 'Embroidery — Aurix Branding')
@section('meta_description', 'Premium embroidery services in Nairobi for uniforms, polos, hoodies, caps, and corporate apparel. Durable stitching and precise logo placement with nationwide delivery.')

@section('content')
    @php
        $whatsappPhone = '254700816670';
        $whatsappUrl = 'https://wa.me/'.$whatsappPhone.'?text='.rawurlencode('Hello Aurix Branding, I would like an embroidery quote.');
    @endphp

    <section class="section-tight bg-white">
        <div class="container-x grid items-center gap-12 lg:grid-cols-2">
            <div>
                <span class="eyebrow">Embroidery branding</span>
                <h1 class="mt-5 text-4xl font-bold leading-[1.05] tracking-tight text-ink sm:text-5xl">Embroidery that elevates your brand.</h1>
                <p class="mt-6 text-lg leading-relaxed text-ink-soft">
                    Aurix Branding delivers premium embroidery for uniforms, caps, polos, hoodies, and corporate apparel. We combine clean digitizing, durable threads, and precise placement for branding that lasts through daily wear.
                </p>
                <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('public.quote', ['product' => 'Embroidery']) }}" class="btn btn-primary btn-lg">Request a Quote</a>
                    <a href="{{ route('public.products.index', ['category' => 'embroidery']) }}" class="btn btn-outline btn-lg">View Apparel</a>
                </div>
            </div>
            <div class="media media-4x3 media--cover rounded-2xl border border-line">
                <img src="{{ asset('images/aurix-embroidery-production-collage.png') }}" alt="Aurix Branding embroidery production" width="1200" height="900" fetchpriority="high">
            </div>
        </div>
    </section>

    <section class="border-y border-line bg-neutral">
        <div class="container-x grid grid-cols-1 gap-8 py-10 sm:grid-cols-3">
            @foreach([
                ['Small or Bulk', 'Flexible order sizes.'],
                ['Tailored Fit', 'Made to your brand.'],
                ['Regional Reach', 'Nairobi and nationwide.'],
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

    <section class="section bg-white">
        <div class="container-x">
            <div class="section-head">
                <span class="eyebrow">Key services</span>
                <h2 class="section-title">Embroidery solutions built for visibility</h2>
            </div>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                @foreach([
                    ['Embroidered Patches', 'Custom patches for uniforms, workwear, and promotional gear with durable stitching.', 'images/aurix-branding-collage.png'],
                    ['Embroidered Uniforms', 'Professional uniforms for corporate, hospitality, schools, and institutions.', 'images/aurix-polo-category.png'],
                    ['Embroidered Caps & Hats', 'High-visibility headwear with precision embroidery for staff and events.', 'images/aurix-design-categories.png'],
                    ['Custom Embroidered Apparel', 'Polos, jackets, hoodies, and premium wearables tailored to your brand.', 'images/aurix-hoodie-category.png'],
                ] as $service)
                    <article class="card flex items-center gap-6 p-6">
                        <div class="media media-square media--cover h-24 w-24 flex-none rounded-full border border-accent-soft">
                            <img src="{{ asset($service[2]) }}" alt="{{ $service[0] }}" loading="lazy" width="200" height="200">
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-ink">{{ $service[0] }}</h3>
                            <p class="mt-1.5 text-sm leading-relaxed text-ink-soft">{{ $service[1] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-tight bg-cream">
        <div class="container-x grid gap-8 lg:grid-cols-2">
            <div class="card p-6 sm:p-8">
                <span class="eyebrow">Brand impact</span>
                <h2 class="mt-4 text-2xl font-bold text-ink">Stand out with professional embroidery</h2>
                <ul class="mt-5 grid gap-3 text-ink-soft">
                    @foreach([
                        'Clean, consistent logo reproduction.',
                        'Premium threads that hold colour and shape.',
                        'Durable finishes for daily wear and long-term use.',
                        'Placement guidance for polos, caps, hoodies, jackets, and bags.',
                    ] as $point)
                        <li class="flex gap-3"><span class="mt-1 text-accent-deep">&#8226;</span>{{ $point }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="card p-6 sm:p-8">
                <span class="eyebrow">How we work</span>
                <h2 class="mt-4 text-2xl font-bold text-ink">Our process</h2>
                <div class="mt-6 grid gap-4">
                    @foreach([
                        ['01', 'Design & Digitizing', 'We refine your logo and prepare precise embroidery files.'],
                        ['02', 'Sampling & Approval', 'We test stitch quality and finalize placement with you.'],
                        ['03', 'Production & Delivery', 'We scale from small to large orders with consistent output.'],
                    ] as $step)
                        <div class="flex items-start gap-4">
                            <span class="inline-flex h-10 w-10 flex-none items-center justify-center rounded-full bg-brand text-sm font-semibold text-white">{{ $step[0] }}</span>
                            <div>
                                <div class="font-semibold text-ink">{{ $step[1] }}</div>
                                <p class="text-sm text-ink-soft">{{ $step[2] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="section-tight bg-white">
        <div class="container-x">
            <div class="section-head">
                <span class="eyebrow">Examples</span>
                <h2 class="section-title">Embroidery that represents your brand</h2>
            </div>
            <div class="overflow-hidden rounded-2xl border border-line">
                <img src="{{ asset('images/aurix-embroidery-examples.png') }}" alt="Aurix Branding embroidery examples" loading="lazy" width="1600" height="900">
            </div>
        </div>
    </section>

    <section class="section bg-brand text-white">
        <div class="container-x text-center">
            <h2 class="mx-auto max-w-2xl text-3xl font-bold tracking-tight sm:text-4xl">Let's build your embroidery identity</h2>
            <p class="mx-auto mt-5 max-w-2xl text-lg text-gray-300">Share your logo and project details. We'll recommend the best embroidery options for your team, event, or retail line.</p>
            <div class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <a href="{{ route('public.quote', ['product' => 'Embroidery']) }}" class="btn btn-accent btn-lg">Request a Quote</a>
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="btn btn-whatsapp btn-lg">WhatsApp Us</a>
            </div>
        </div>
    </section>
@endsection
