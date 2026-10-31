@extends('layouts.taf')

@section('title', 'Contact Aurix Branding | Request a Quote in Nairobi, Kenya')
@section('meta_description', 'Contact Aurix Branding in Nairobi, Kenya for a branding or printing quote. Call, email, or WhatsApp us to discuss apparel, embroidery, signage, corporate gifts, and business printing.')

@section('content')
    @php
        $contact = \Illuminate\Support\Facades\Schema::hasTable('site_settings')
            ? \App\Models\SiteSetting::contactSettings()
            : \App\Models\SiteSetting::defaultContactSettings();
        $phone = $contact['phone'] ?? '+254 700816670';
        $phoneRaw = preg_replace('/\D+/', '', $phone);
        $email = $contact['email'] ?? 'info@aurixbranding.co.ke';
        $whatsapp = preg_replace('/\D+/', '', $contact['whatsapp_phone'] ?? $phoneRaw) ?: '254700816670';
        $whatsappUrl = 'https://wa.me/'.$whatsapp.'?text='.rawurlencode('Hello Aurix Branding, I would like a quote.');
    @endphp

    <section class="taf-page-hero">
        <div class="taf-wrap">
            <nav class="taf-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Home</a><span aria-hidden="true">/</span><span>Contact</span>
            </nav>
            <span class="taf-eyebrow">Get in touch</span>
            <h1>Contact Aurix Branding</h1>
            <p>Tell us what you're branding and we'll help you choose the right materials, printing method, and finishing.</p>
        </div>
    </section>

    <section class="taf-section">
        <div class="taf-wrap">
            <div class="taf-split" style="display:grid;grid-template-columns:minmax(0,1fr) minmax(300px,0.9fr);gap:34px;align-items:start;">
                <div class="taf-content-card">
                    <h2 style="margin-top:0;">Request a quote</h2>
                    @include('partials.quote-form', ['product' => $product ?? ''])
                </div>
                <aside class="taf-prose" style="margin:0;">
                    <h2 style="margin-top:0;">Contact details</h2>
                    <ul style="list-style:none;padding:0;">
                        <li style="margin-bottom:14px;"><strong>Phone:</strong> <a href="tel:+{{ $phoneRaw }}">{{ $phone }}</a></li>
                        <li style="margin-bottom:14px;"><strong>Email:</strong> <a href="mailto:{{ $email }}">{{ $email }}</a></li>
                        <li style="margin-bottom:14px;"><strong>Location:</strong> Nairobi, Kenya</li>
                        <li style="margin-bottom:14px;"><strong>Hours:</strong> Mon–Fri 8am – 5pm, Sat 8am – 12pm</li>
                    </ul>
                    <div class="taf-hero-actions" style="margin-top:20px;">
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="taf-primary-btn" style="background:#25d366;">WhatsApp Us</a>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
