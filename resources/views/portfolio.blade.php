@extends('layouts.taf')

@section('title', 'Our Work & Portfolio | Aurix Branding')
@section('meta_description', 'Browse selected branding and printing work completed by Aurix Branding in Kenya — uniforms, embroidery, signage, and promotional merchandise.')

@section('content')
    @php $quoteUrl = route('public.quote'); @endphp

    <section class="taf-page-hero">
        <div class="taf-wrap">
            <nav class="taf-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Home</a><span aria-hidden="true">/</span><span>Portfolio</span>
            </nav>
            <span class="taf-eyebrow">Our work</span>
            <h1>Our Work &amp; Portfolio</h1>
            <p>A selection of branding and printing projects completed for businesses across Kenya.</p>
        </div>
    </section>

    <section class="taf-section">
        <div class="taf-wrap">
            <div class="taf-work-grid" style="grid-template-columns:repeat(3,minmax(0,1fr));gap:18px;">
                @forelse($works ?? [] as $work)
                    <div class="taf-work-card" style="display:block;overflow:hidden;border:1px solid var(--taf-line);border-radius:12px;background:#fffaf1;">
                        @if($work->image_url)
                            <img src="{{ $work->image_url }}" alt="{{ $work->name }}" loading="lazy" width="600" height="450" style="width:100%;aspect-ratio:4/3;object-fit:cover;">
                        @else
                            <img src="{{ asset('images/aurix-branding-collage.png') }}" alt="{{ $work->name }}" loading="lazy" width="600" height="450" style="width:100%;aspect-ratio:4/3;object-fit:cover;">
                        @endif
                        <strong style="display:block;padding:14px 16px;">{{ $work->name }}</strong>
                    </div>
                @empty
                    <div class="taf-dashboard-empty" style="grid-column:1/-1;">Completed projects will be published here once available.</div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="taf-section taf-category-section">
        <div class="taf-wrap">
            <div class="taf-prose" style="max-width:720px;">
                <h2>See the results for your project</h2>
                <p>Every project is different. Tell us what you need branded and we'll show you suitable material, printing, and finishing options for your use case.</p>
                <p><a href="{{ $quoteUrl }}">Request a quote</a> to get started.</p>
            </div>
        </div>
    </section>
@endsection
