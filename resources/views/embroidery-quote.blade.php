@extends('layouts.public')

@section('title', 'Embroidery Quote — Aurix Branding')
@section('meta_description', 'Request an embroidery quote from Aurix Branding for uniforms, polos, hoodies, caps, and corporate apparel.')

@section('content')
    <section class="section-tight bg-neutral">
        <div class="container-x">
            <div class="section-head section-head--center">
                <span class="eyebrow">Embroidery</span>
                <h1 class="section-title">Request an embroidery quote</h1>
                <p class="section-sub">Tell us what you need embroidered — garment type, quantity, timeline, and logo placement — and we'll send a tailored quotation.</p>
            </div>

            <div class="mx-auto max-w-3xl card p-6 sm:p-10">
                @include('partials.quote-form', ['product' => 'Embroidery'])
            </div>
        </div>
    </section>
@endsection
