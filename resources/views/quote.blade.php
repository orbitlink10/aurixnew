@extends('layouts.taf')

@section('title', 'Request a Quote — Aurix Branding')
@section('meta_description', 'Request a custom branding or printing quote from Aurix Branding. Tell us your requirements and receive a quotation for apparel, embroidery, signage, and promotional merchandise.')

@section('content')
    <section class="taf-page-hero">
        <div class="taf-wrap">
            <nav class="taf-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Home</a><span aria-hidden="true">/</span><span>Request a Quote</span>
            </nav>
            <span class="taf-eyebrow">Quotation</span>
            <h1>Request a Quote</h1>
            <p>Tell us what you're branding and we'll help you choose the right materials, printing method, and finishing. We respond with a tailored quotation based on your quantity and requirements.</p>
        </div>
    </section>

    <section class="taf-section" style="padding-top:28px;">
        <div class="taf-wrap" style="max-width:820px;">
            <div class="taf-content-card">
                @include('partials.quote-form', ['product' => $product ?? ''])
            </div>
        </div>
    </section>
@endsection
