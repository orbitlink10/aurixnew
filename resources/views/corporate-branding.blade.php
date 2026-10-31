@extends('layouts.taf')

@section('title', 'Corporate Branding in Nairobi, Kenya | Aurix Branding')
@section('meta_description', 'Corporate branding services in Nairobi — branded uniforms, stationery, signage, and promotional merchandise that keep your business consistent and professional.')

@section('content')
    @php
        $quoteUrl = route('public.quote');
        $items = [
            ['Branded Uniforms', 'Polos, shirts, and workwear branded for your team.', route('public.products.index', ['category' => 'uniforms']), 'images/aurix-polo-category.png'],
            ['Business Stationery', 'Business cards, letterheads, and branded documents.', route('public.products.index', ['q' => 'business card']), 'images/aurix-business-cards.png'],
            ['Office & Retail Signage', 'Signage that presents your brand clearly indoors and outdoors.', route('public.products.index', ['q' => 'signage']), 'images/aurix-design-categories.png'],
            ['Branded Merchandise', 'Gifts and giveaways that keep your brand top of mind.', route('public.products.index', ['q' => 'gift']), 'images/aurix-hoodie-category.png'],
        ];
    @endphp

    <section class="taf-page-hero">
        <div class="taf-wrap">
            <nav class="taf-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Home</a><span aria-hidden="true">/</span><a href="{{ route('public.services') }}">Services</a><span aria-hidden="true">/</span><span>Corporate Branding</span>
            </nav>
            <span class="taf-eyebrow">Corporate branding</span>
            <h1>Corporate Branding in Nairobi, Kenya</h1>
            <p>Present a consistent, professional brand across your uniforms, stationery, signage, and promotional items.</p>
            <div class="taf-hero-actions">
                <a href="{{ $quoteUrl }}" class="taf-primary-btn">Request a Quote</a>
            </div>
        </div>
    </section>

    <section class="taf-section">
        <div class="taf-wrap">
            <div class="taf-product-grid">
                @foreach($items as [$title, $text, $href, $image])
                    <a href="{{ $href }}" class="taf-product-card">
                        <span class="taf-product-media">
                            <img src="{{ asset($image) }}" alt="{{ $title }}" loading="lazy" width="400" height="400">
                        </span>
                        <span class="taf-product-info">
                            <strong>{{ $title }}</strong>
                            <span class="taf-product-quote">{{ $text }}</span>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="taf-section taf-category-section">
        <div class="taf-wrap">
            <div class="taf-section-head" style="max-width:760px;">
                <span class="taf-category-kicker">Why it matters</span>
                <h2>Consistent branding builds trust</h2>
            </div>
            <div class="taf-prose" style="max-width:760px;">
                <p>Customers and partners form an impression from every touchpoint. Consistent colours, logos, and finishes across your uniforms, documents, and signage help your business look established and dependable.</p>
                <h3>What we help with</h3>
                <ul>
                    <li>Logo and artwork preparation for production</li>
                    <li>Matching colours and finishes across different products</li>
                    <li>Bulk orders for teams, branches, and events</li>
                    <li>Nationwide delivery and Nairobi pickup</li>
                </ul>
                <p>Tell us what you are branding and <a href="{{ $quoteUrl }}">request a quote</a>.</p>
            </div>
        </div>
    </section>
@endsection
