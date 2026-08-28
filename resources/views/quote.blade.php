@extends('layouts.public')

@section('title', 'Request a Quote — Aurix Branding')
@section('meta_description', 'Request a custom branding or printing quote from Aurix Branding. Tell us your requirements and receive a quotation for apparel, embroidery, signage, and promotional merchandise.')

@section('content')
    <section class="section-tight bg-neutral">
        <div class="container-x">
            <div class="section-head section-head--center">
                <span class="eyebrow">Quotation</span>
                <h1 class="section-title">Request a Quote</h1>
                <p class="section-sub">Tell us what you're branding and we'll help you choose the right materials, printing method, and finishing. We respond with a tailored quotation based on your quantity and requirements.</p>
            </div>

            <div class="mx-auto max-w-3xl card p-6 sm:p-10">
                @include('partials.quote-form', ['product' => $product ?? ''])
            </div>

            <div class="mx-auto mt-10 flex max-w-3xl flex-col items-center justify-center gap-4 sm:flex-row">
                <span class="text-sm text-ink-soft">Prefer to chat directly?</span>
                <a href="https://wa.me/{{ preg_replace('/\D+/', '', $contact['whatsapp_phone'] ?? '254700816670') }}?text={{ rawurlencode('Hello Aurix Branding, I would like a quotation.') }}" target="_blank" rel="noopener" class="btn btn-whatsapp">WhatsApp Us</a>
            </div>
        </div>
    </section>
@endsection
