@extends('layouts.taf')

@section('title', 'Branding & Printing Services in Nairobi, Kenya | Aurix Branding')
@section('meta_description', 'Explore Aurix Branding services in Nairobi: T-shirt and apparel printing, corporate branding, uniforms, embroidery, promotional merchandise, signage, and business printing.')

@section('content')
    @php
        $quoteUrl = route('public.quote');
        $services = [
            ['title' => 'T-Shirt & Apparel Printing', 'text' => 'Custom T-shirts, polos, and branded apparel for teams, events, and retail using DTF, screen printing, and vinyl.', 'href' => route('public.products.index', ['q' => 't-shirt']), 'image' => 'images/aurix-tshirt-category.png'],
            ['title' => 'Corporate Branding', 'text' => 'Uniforms, stationery, and workplace branding that keep your business looking professional and consistent.', 'href' => route('public.corporate-branding'), 'image' => 'images/aurix-branding-collage.png'],
            ['title' => 'Uniform Branding', 'text' => 'Branded uniforms for corporates, hospitality, schools, and institutions with durable production and finishing.', 'href' => route('public.products.index', ['category' => 'uniforms']), 'image' => 'images/aurix-polo-category.png'],
            ['title' => 'Embroidery', 'text' => 'Premium embroidery for uniforms, caps, polos, and hoodies with precise logo placement and lasting threads.', 'href' => route('public.embroidery'), 'image' => 'images/aurix-embroidery-production-collage.png'],
            ['title' => 'Corporate Gifts & Merchandise', 'text' => 'Branded gifts and promotional merchandise that keep your brand in front of customers.', 'href' => route('public.products.index', ['q' => 'gift']), 'image' => 'images/aurix-hoodie-category.png'],
            ['title' => 'Signage & Large Format Printing', 'text' => 'Outdoor signage, roll-up banners, and large format printing for indoor and outdoor visibility.', 'href' => route('public.products.index', ['q' => 'signage']), 'image' => 'images/aurix-design-categories.png'],
            ['title' => 'Business Printing', 'text' => 'Business cards, stationery, and printed materials that build trust and consistency.', 'href' => route('public.products.index', ['q' => 'business card']), 'image' => 'images/aurix-business-cards.png'],
        ];
    @endphp

    <section class="taf-page-hero">
        <div class="taf-wrap">
            <nav class="taf-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Home</a><span aria-hidden="true">/</span><span>Services</span>
            </nav>
            <span class="taf-eyebrow">What we do</span>
            <h1>Branding &amp; Printing Services in Nairobi, Kenya</h1>
            <p>From custom apparel to corporate signage, Aurix Branding provides the branding and printing services Kenyan businesses need to look professional and get noticed.</p>
            <div class="taf-hero-actions">
                <a href="{{ $quoteUrl }}" class="taf-primary-btn">Request a Quote</a>
            </div>
        </div>
    </section>

    <section class="taf-section">
        <div class="taf-wrap">
            <div class="taf-product-grid">
                @foreach($services as $service)
                    <a href="{{ $service['href'] }}" class="taf-product-card">
                        <span class="taf-product-media">
                            <img src="{{ asset($service['image']) }}" alt="{{ $service['title'] }}" loading="lazy" width="400" height="400">
                        </span>
                        <span class="taf-product-info">
                            <strong>{{ $service['title'] }}</strong>
                            <span class="taf-product-quote">{{ $service['text'] }}</span>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="taf-section taf-category-section">
        <div class="taf-wrap">
            <div class="taf-section-head" style="max-width:720px;">
                <span class="taf-category-kicker">How we work</span>
                <h2>Quotation-based production</h2>
            </div>
            <div class="taf-prose" style="max-width:760px;">
                <p>Every project is quoted based on your quantity, material, printing method, finishing, and timeline. Send your requirements and we will recommend the right approach for your budget and use case.</p>
                <h3>What to share for a quote</h3>
                <ul>
                    <li>The product or service you need</li>
                    <li>Quantities and sizes</li>
                    <li>Your artwork or logo (or tell us you need design help)</li>
                    <li>Your deadline and delivery location</li>
                </ul>
                <p><a href="{{ $quoteUrl }}">Request a quote</a> and our team will respond with pricing and production details.</p>
            </div>
        </div>
    </section>
@endsection
