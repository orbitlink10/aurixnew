@extends('layouts.taf')

@section('title', 'Embroidery Quote — Aurix Branding')
@section('meta_description', 'Request an embroidery quote from Aurix Branding for uniforms, polos, hoodies, caps, and corporate apparel.')

@section('content')
    <section class="taf-page-hero">
        <div class="taf-wrap">
            <nav class="taf-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Home</a><span aria-hidden="true">/</span><a href="{{ route('public.embroidery') }}">Embroidery</a><span aria-hidden="true">/</span><span>Quote</span>
            </nav>
            <span class="taf-eyebrow">Embroidery</span>
            <h1>Request an Embroidery Quote</h1>
            <p>Tell us what you need embroidered — garment type, quantity, timeline, and logo placement — and we'll send a tailored quotation.</p>
        </div>
    </section>

    <section class="taf-section" style="padding-top:28px;">
        <div class="taf-wrap" style="max-width:820px;">
            <div class="taf-content-card">
                @include('partials.quote-form', ['product' => 'Embroidery'])
            </div>
        </div>
    </section>
@endsection
