<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name') . ' — Premium Branding & Printing in Kenya')</title>
    <meta name="description" content="@yield('meta_description', 'Aurix Branding provides premium corporate branding, custom apparel, embroidery, signage, promotional merchandise, and printed materials with reliable production and nationwide delivery across Kenya.')">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    @hasSection('canonical')
        <link rel="canonical" href="@yield('canonical')">
    @else
        <link rel="canonical" href="{{ url()->current() }}">
    @endif

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="@yield('og_title', 'Aurix Branding — Premium Branding & Printing in Kenya')">
    <meta property="og:description" content="@yield('og_description', 'Professional corporate branding, apparel printing, embroidery, signage, and promotional merchandise with nationwide delivery.')">
    <meta property="og:url" content="{{ url()->current() }}">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
    @endif
    <meta name="twitter:card" content="summary_large_image">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/aurix-branding-logo.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php
        use Illuminate\Support\Facades\Schema;
        use App\Models\SiteSetting;

        $siteContact = isset($contactSettings) && is_array($contactSettings)
            ? $contactSettings
            : (Schema::hasTable('site_settings') ? SiteSetting::contactSettings() : SiteSetting::defaultContactSettings());
        $siteLogo = isset($logoUrl) && $logoUrl ? $logoUrl : (Schema::hasTable('site_settings') ? SiteSetting::logoUrl() : null);
        $siteDisplayPhone = $siteContact['phone'] ?? '+254 700 816 670';
        $sitePhoneRaw = preg_replace('/\D+/', '', $siteDisplayPhone);
        $siteEmail = $siteContact['email'] ?? 'info@aurixbranding.co.ke';
        $siteWhatsapp = preg_replace('/\D+/', '', $siteContact['whatsapp_phone'] ?? $sitePhoneRaw);
        $siteWhatsappUrl = 'https://wa.me/'.$siteWhatsapp.'?text='.rawurlencode($siteContact['whatsapp_message'] ?? 'Hello Aurix Branding, I would like a quote.');
        $quoteUrl = route('public.quote');
        $requestUri = request()->path();
    @endphp

    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": ["Organization", "LocalBusiness"],
        "@@id": "{{ url('/') }}#organization",
        "name": "{{ config('app.name') }}",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/aurix-branding-logo.png') }}",
        "image": "{{ asset('images/aurix-branding-logo.png') }}",
        "telephone": "+{{ $sitePhoneRaw }}",
        "email": "{{ $siteEmail }}",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Nairobi",
            "addressCountry": "KE"
        },
        "areaServed": "KE",
        "priceRange": "$$"
    }
    </script>
    @stack('head')
</head>
<body class="antialiased">
    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-[100] focus:bg-white focus:px-4 focus:py-2 focus:rounded-md focus:shadow">Skip to content</a>

    <header class="site-header">
        <div class="container-x site-header__bar">
            <a href="{{ url('/') }}" class="site-brand" aria-label="Aurix Branding home">
                <img src="{{ $siteLogo ?: asset('images/aurix-branding-logo.png') }}" alt="Aurix Branding logo" width="42" height="42">
                <span>Aurix Branding</span>
            </a>

            <nav class="site-nav" aria-label="Main navigation">
                <a href="{{ route('public.products.index') }}" class="site-nav__link {{ $requestUri === 'products' ? 'is-active' : '' }}">Products</a>
                <a href="{{ url('/#services') }}" class="site-nav__link">Services</a>
                <a href="{{ route('public.embroidery') }}" class="site-nav__link {{ $requestUri === 'embroidery' ? 'is-active' : '' }}">Embroidery</a>
                <a href="{{ route('public.products.index', ['category' => 'corporate']) }}" class="site-nav__link">Corporate Branding</a>
                <a href="{{ url('/#work') }}" class="site-nav__link">Portfolio</a>
                <a href="{{ url('/#about') }}" class="site-nav__link">About</a>
                <a href="{{ url('/#contact') }}" class="site-nav__link">Contact</a>
            </nav>

            <a href="{{ route('public.products.index') }}" class="site-nav__link ml-auto hidden lg:inline-flex" aria-label="Search products" title="Search">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 6 16.65a7.5 7.5 0 0 0 10.65 0Z"/></svg>
            </a>

            <div class="site-header__cta">
                <a href="{{ $quoteUrl }}" class="btn btn-primary btn-sm">Request a Quote</a>
            </div>

            <button class="nav-toggle" type="button" data-mobile-open aria-label="Open menu">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>
    </header>

    <div class="mobile-menu" data-mobile-menu>
        <div class="mobile-menu__overlay" data-mobile-close></div>
        <div class="mobile-menu__panel" role="dialog" aria-modal="true" aria-label="Menu">
            <div class="mobile-menu__head">
                <span class="site-brand">
                    <img src="{{ $siteLogo ?: asset('images/aurix-branding-logo.png') }}" alt="" width="38" height="38">
                    <span>Aurix Branding</span>
                </span>
                <button class="mobile-menu__close" type="button" data-mobile-close aria-label="Close menu">&times;</button>
            </div>
            <nav class="mobile-menu__nav" aria-label="Mobile navigation">
                <a href="{{ url('/') }}" class="mobile-menu__link">Home</a>
                <a href="{{ route('public.products.index') }}" class="mobile-menu__link">Products</a>
                <a href="{{ url('/#services') }}" class="mobile-menu__link">Services</a>
                <a href="{{ route('public.embroidery') }}" class="mobile-menu__link">Embroidery</a>
                <a href="{{ route('public.products.index', ['category' => 'corporate']) }}" class="mobile-menu__link">Corporate Branding</a>
                <a href="{{ url('/#work') }}" class="mobile-menu__link">Portfolio</a>
                <a href="{{ url('/#about') }}" class="mobile-menu__link">About</a>
                <a href="{{ url('/#contact') }}" class="mobile-menu__link">Contact</a>
                <a href="{{ $quoteUrl }}" class="mobile-menu__link">Request a Quote</a>
            </nav>
            <a href="{{ $quoteUrl }}" class="btn btn-primary btn-block mt-6">Request a Quote</a>
        </div>
    </div>

    <main id="main">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container-x">
            <div class="site-footer__grid">
                <div>
                    <div class="site-footer__brand">Aurix Branding</div>
                    <p class="site-footer__about">A premium corporate branding and printing company in Nairobi, Kenya. We produce professional apparel, embroidery, signage, promotional merchandise, and printed materials for businesses, SMEs, schools, and institutions.</p>
                    <div class="site-footer__social">
                        <a href="#" aria-label="Facebook">f</a>
                        <a href="#" aria-label="Instagram">ig</a>
                        <a href="#" aria-label="LinkedIn">in</a>
                        <a href="#" aria-label="X">x</a>
                    </div>
                </div>
                <div>
                    <h4>Services</h4>
                    <ul class="site-footer__links">
                        <li><a href="{{ route('public.products.index') }}">Corporate Branding</a></li>
                        <li><a href="{{ route('public.products.index', ['category' => 'apparel']) }}">T-Shirt &amp; Apparel Printing</a></li>
                        <li><a href="{{ route('public.embroidery') }}">Embroidery</a></li>
                        <li><a href="{{ route('public.products.index') }}">Promotional Merchandise</a></li>
                        <li><a href="{{ route('public.products.index') }}">Signage &amp; Large Format</a></li>
                        <li><a href="{{ route('public.products.index') }}">Business Printing</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Useful Links</h4>
                    <ul class="site-footer__links">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ route('public.products.index') }}">Products</a></li>
                        <li><a href="{{ url('/#work') }}">Our Work</a></li>
                        <li><a href="{{ url('/#about') }}">About Us</a></li>
                        <li><a href="{{ route('public.quote') }}">Request a Quote</a></li>
                        <li><a href="{{ route('public.embroidery') }}">Embroidery</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Contact</h4>
                    <div class="site-footer__contact">
                        <a href="tel:+{{ $sitePhoneRaw }}">{{ $siteDisplayPhone }}</a>
                        <a href="mailto:{{ $siteEmail }}">{{ $siteEmail }}</a>
                        <span>Nairobi, Kenya</span>
                        <span>Mon–Fri: 8am – 5pm</span>
                        <span>Sat: 8am – 12pm</span>
                    </div>
                </div>
            </div>
            <div class="site-footer__bottom">&copy; {{ now()->year }} Aurix Branding. Premium branding, printing, signage, and promotional products across Kenya.</div>
        </div>
    </footer>

    <a class="whatsapp-float" href="{{ $siteWhatsappUrl }}" target="_blank" rel="noopener" aria-label="Chat with Aurix Branding on WhatsApp">
        <svg viewBox="0 0 32 32" aria-hidden="true" focusable="false">
            <path fill="currentColor" d="M16.02 3.2c-7.06 0-12.8 5.68-12.8 12.68 0 2.24.6 4.42 1.74 6.34L3.1 29l6.98-1.82a12.9 12.9 0 0 0 5.94 1.46c7.06 0 12.8-5.68 12.8-12.68S23.08 3.2 16.02 3.2Zm0 23.28c-1.9 0-3.76-.5-5.38-1.44l-.38-.22-4.14 1.08 1.1-4.02-.24-.42a10.35 10.35 0 0 1-1.6-5.58c0-5.8 4.78-10.52 10.64-10.52s10.64 4.72 10.64 10.52-4.78 10.6-10.64 10.6Zm5.82-7.88c-.32-.16-1.9-.94-2.2-1.04-.3-.12-.52-.16-.74.16-.22.32-.84 1.04-1.04 1.26-.18.22-.38.24-.7.08-.32-.16-1.36-.5-2.58-1.58-.96-.84-1.6-1.88-1.78-2.2-.18-.32-.02-.5.14-.66.14-.14.32-.38.48-.56.16-.18.22-.32.32-.54.1-.22.06-.4-.02-.56-.08-.16-.74-1.78-1.02-2.44-.26-.64-.54-.56-.74-.56h-.64c-.22 0-.56.08-.86.4-.3.32-1.14 1.1-1.14 2.68s1.18 3.12 1.34 3.34c.16.22 2.32 3.52 5.62 4.94.78.34 1.4.54 1.88.7.8.24 1.52.2 2.08.12.64-.1 1.9-.78 2.16-1.52.26-.74.26-1.38.18-1.52-.08-.14-.28-.22-.6-.38Z"/>
        </svg>
    </a>

    @stack('scripts')
</body>
</html>
