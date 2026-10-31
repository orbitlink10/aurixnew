@extends('layouts.taf')

@section('title', 'Embroidery Services in Nairobi, Kenya | Aurix Branding')
@section('meta_description', 'Premium embroidery services in Nairobi for uniforms, polos, hoodies, caps, and corporate apparel. Durable stitching and precise logo placement with nationwide delivery.')

@section('content')
    @php $quoteUrl = route('public.quote', ['product' => 'Embroidery']); @endphp

    <section class="taf-page-hero">
        <div class="taf-wrap">
            <nav class="taf-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Home</a><span aria-hidden="true">/</span><a href="{{ route('public.services') }}">Services</a><span aria-hidden="true">/</span><span>Embroidery</span>
            </nav>
            <span class="taf-eyebrow">Embroidery branding</span>
            <h1>Embroidery Services in Nairobi, Kenya</h1>
            <p>Premium embroidery for uniforms, caps, polos, hoodies, and corporate apparel. Clean digitizing, durable threads, and precise placement for branding that lasts.</p>
            <div class="taf-hero-actions">
                <a href="{{ $quoteUrl }}" class="taf-primary-btn">Request a Quote</a>
                <a href="{{ route('public.products.index', ['category' => 'embroidery']) }}" class="taf-link-btn">View Apparel</a>
            </div>
        </div>
    </section>

    <section class="taf-section">
        <div class="taf-wrap">
            <div class="taf-product-grid">
                @foreach([
                    ['Embroidered Patches', 'Custom patches for uniforms, workwear, and promotional gear with durable stitching.', 'images/aurix-branding-collage.png'],
                    ['Embroidered Uniforms', 'Professional uniforms for corporate, hospitality, schools, and institutions.', 'images/aurix-polo-category.png'],
                    ['Embroidered Caps & Hats', 'High-visibility headwear with precision embroidery for staff and events.', 'images/aurix-design-categories.png'],
                    ['Custom Embroidered Apparel', 'Polos, jackets, hoodies, and premium wearables tailored to your brand.', 'images/aurix-hoodie-category.png'],
                ] as $service)
                    <div class="taf-content-card">
                        <img src="{{ asset($service[2]) }}" alt="{{ $service[0] }}" loading="lazy" width="120" height="120" style="width:120px;height:120px;object-fit:cover;border-radius:999px;border:3px solid var(--taf-line);">
                        <h2 style="margin-top:16px;font-size:20px;">{{ $service[0] }}</h2>
                        <p style="color:var(--taf-muted);">{{ $service[1] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="taf-section taf-category-section">
        <div class="taf-wrap">
            <div class="taf-prose" style="max-width:760px;">
                <h2>How embroidery works</h2>
                <ol>
                    <li><strong>Design &amp; digitizing</strong> — we refine your logo and prepare precise embroidery files.</li>
                    <li><strong>Sampling &amp; approval</strong> — we test stitch quality and finalize placement with you.</li>
                    <li><strong>Production &amp; delivery</strong> — we scale from small to large orders with consistent output.</li>
                </ol>
                <p>Ready to start? <a href="{{ $quoteUrl }}">Request an embroidery quote</a>.</p>
            </div>
        </div>
    </section>
@endsection
