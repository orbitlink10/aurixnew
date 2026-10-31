@extends('layouts.taf')

@section('title', 'About Aurix Branding | Branding & Printing in Nairobi, Kenya')
@section('meta_description', 'Aurix Branding is a branding and printing company in Nairobi, Kenya, providing custom apparel, embroidery, signage, corporate gifts, and business printing with nationwide delivery.')

@section('content')
    @php $quoteUrl = route('public.quote'); @endphp

    <section class="taf-page-hero">
        <div class="taf-wrap">
            <nav class="taf-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Home</a><span aria-hidden="true">/</span><span>About</span>
            </nav>
            <span class="taf-eyebrow">About us</span>
            <h1>About Aurix Branding</h1>
            <p>A branding and printing partner for businesses across Kenya.</p>
        </div>
    </section>

    <section class="taf-section">
        <div class="taf-wrap">
            <div class="taf-prose" style="max-width:760px;">
                <p>Aurix Branding helps businesses, schools, events, and institutions create professional branded apparel, signage, promotional merchandise, and printed materials. We support our customers from artwork through production to nationwide delivery.</p>
                <h2>What we do</h2>
                <p>Our services cover the core branding and printing needs of a growing business:</p>
                <ul>
                    <li>T-shirt and apparel printing</li>
                    <li>Corporate and uniform branding</li>
                    <li>Embroidery</li>
                    <li>Corporate gifts and promotional merchandise</li>
                    <li>Signage and large format printing</li>
                    <li>Business printing</li>
                </ul>
                <p>Explore our <a href="{{ route('public.services') }}">services</a> or <a href="{{ route('public.products.index') }}">products</a> for more detail.</p>

                <h2>How we work</h2>
                <p>Pricing is quotation-based because each project depends on quantity, materials, printing method, and finishing. Share your requirements and we will recommend the right approach and provide a tailored quote.</p>

                <h2>Our commitment</h2>
                <ul>
                    <li>Clear communication from artwork to delivery</li>
                    <li>Quality checks before dispatch</li>
                    <li>Nationwide delivery with pickup in Nairobi</li>
                </ul>

                <p>Ready to start? <a href="{{ $quoteUrl }}">Request a quote</a> and tell us what you are branding.</p>
            </div>
        </div>
    </section>
@endsection
