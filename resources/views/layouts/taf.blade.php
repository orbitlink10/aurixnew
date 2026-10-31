<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Branding & Printing in Nairobi, Kenya | Aurix Branding')</title>
    <meta name="description" content="@yield('meta_description', 'Aurix Branding provides custom T-shirt and apparel printing, corporate branding, uniforms, embroidery, promotional merchandise, signage, and business printing in Nairobi with nationwide delivery across Kenya.')">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    @hasSection('canonical')
        <link rel="canonical" href="@yield('canonical')">
    @else
        <link rel="canonical" href="{{ url()->current() }}">
    @endif

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="@yield('title', 'Branding & Printing in Nairobi, Kenya | Aurix Branding')">
    <meta property="og:description" content="@yield('meta_description', 'Custom branding and printing in Nairobi, Kenya — T-shirts, uniforms, embroidery, signage, corporate gifts, and business printing.')">
    <meta property="og:url" content="{{ url()->current() }}">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
    @endif
    <meta name="twitter:card" content="summary_large_image">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://aurixbranding.co.ke" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/aurix-branding-logo.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php
        use Illuminate\Support\Facades\Schema;
        use App\Models\SiteSetting;

        $siteContact = Schema::hasTable('site_settings')
            ? SiteSetting::contactSettings()
            : SiteSetting::defaultContactSettings();
        $siteLogo = Schema::hasTable('site_settings') ? SiteSetting::logoUrl() : null;
        $sitePhone = $siteContact['phone'] ?? '+254 700816670';
        $sitePhoneRaw = preg_replace('/\D+/', '', $sitePhone);
        $siteEmail = $siteContact['email'] ?? 'info@aurixbranding.co.ke';
        $siteWhatsapp = preg_replace('/\D+/', '', $siteContact['whatsapp_phone'] ?? $sitePhoneRaw);
        $siteWhatsapp = $siteWhatsapp ?: '254700816670';
        $siteWhatsappUrl = 'https://wa.me/'.$siteWhatsapp.'?text='.rawurlencode($siteContact['whatsapp_message'] ?? 'Hello Aurix Branding, I need a quote.');
        $quoteUrl = route('public.quote');
        $currentPath = '/'.ltrim(request()->path(), '/');

        $navItems = [
            ['label' => 'Products', 'url' => route('public.products.index'), 'path' => '/products'],
            ['label' => 'Services', 'url' => route('public.services')],
            ['label' => 'Corporate Branding', 'url' => route('public.corporate-branding')],
            ['label' => 'Embroidery', 'url' => route('public.embroidery')],
            ['label' => 'Portfolio', 'url' => route('public.portfolio')],
            ['label' => 'About', 'url' => route('public.about')],
            ['label' => 'Contact', 'url' => route('public.contact')],
        ];
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
        "address": {"@@type": "PostalAddress", "addressLocality": "Nairobi", "addressCountry": "KE"},
        "areaServed": "KE",
        "priceRange": "$$"
    }
    </script>
    @stack('head')
</head>
<body class="taf-page">
    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-[100] focus:bg-white focus:px-4 focus:py-2 focus:rounded-md focus:shadow">Skip to content</a>

    @hasSection('marquee')
        @yield('marquee')
    @endif

    <header class="taf-header">
        <div class="taf-wrap taf-header-main">
            <a href="{{ url('/') }}" class="taf-brand" aria-label="Aurix Branding home">
                <img src="{{ $siteLogo ?: asset('images/aurix-branding-logo.png') }}" alt="Aurix Branding logo" width="54" height="54">
                <span>Aurix Branding</span>
            </a>
            <form class="taf-search" action="{{ route('public.products.index') }}" method="get" role="search">
                <input name="q" type="search" placeholder="Search apparel, branding, signage" aria-label="Search products">
                <button type="submit" aria-label="Search">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 6 16.65a7.5 7.5 0 0 0 10.65 0Z"/></svg>
                </button>
            </form>
            <div class="taf-phone">
                <span>{{ $siteContact['support_label'] ?? 'For support call' }}</span>
                <a href="tel:+{{ $sitePhoneRaw }}"><strong>{{ $sitePhone }}</strong></a>
            </div>
        </div>
        <nav class="taf-nav" aria-label="Main navigation">
            <div class="taf-wrap">
                <button class="nav-toggle" type="button" data-mobile-open aria-label="Open menu" aria-controls="mobile-menu">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
                <div class="taf-nav-links">
                    @foreach($navItems as $item)
                        <a href="{{ $item['url'] }}" @class(['is-active' => $currentPath === $item['path']])>{{ $item['label'] }}</a>
                    @endforeach
                    <a href="{{ $quoteUrl }}" class="taf-nav-cta">Request a Quote</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="mobile-menu" id="mobile-menu" data-mobile-menu>
        <div class="mobile-menu__overlay" data-mobile-close></div>
        <div class="mobile-menu__panel" role="dialog" aria-modal="true" aria-label="Menu">
            <div class="mobile-menu__head">
                <span class="taf-brand">
                    <img src="{{ $siteLogo ?: asset('images/aurix-branding-logo.png') }}" alt="" width="40" height="40">
                    <span>Aurix Branding</span>
                </span>
                <button class="mobile-menu__close" type="button" data-mobile-close aria-label="Close menu">&times;</button>
            </div>
            <nav class="mobile-menu__nav" aria-label="Mobile navigation">
                <a href="{{ url('/') }}" class="mobile-menu__link">Home</a>
                @foreach($navItems as $item)
                    <a href="{{ $item['url'] }}" class="mobile-menu__link">{{ $item['label'] }}</a>
                @endforeach
                <a href="{{ $quoteUrl }}" class="mobile-menu__link">Request a Quote</a>
            </nav>
        </div>
    </div>

    <main id="main">
        @yield('content')
    </main>

    <footer class="taf-site-footer">
        <section class="taf-footer-main">
            <div class="taf-footer-container">
                <div class="taf-footer-grid">
                    <div>
                        <h2 class="taf-footer-title">Aurix Branding</h2>
                        <a class="taf-footer-brand" href="{{ url('/') }}"><img src="{{ asset('images/aurix-branding-logo.png') }}" alt="Aurix Branding logo"></a>
                        <p class="taf-footer-about">Premium branding and printing in Nairobi, Kenya. Custom apparel, embroidery, signage, corporate gifts, and business printing with nationwide delivery.</p>
                    </div>
                    <div>
                        <h2 class="taf-footer-title">Our Services</h2>
                        <ul class="taf-footer-services">
                            <li><span class="taf-footer-icon">&#8250;</span><a href="{{ route('public.corporate-branding') }}">Corporate Branding</a></li>
                            <li><span class="taf-footer-icon">&#8250;</span><a href="{{ route('public.services') }}">T-Shirt &amp; Apparel Printing</a></li>
                            <li><span class="taf-footer-icon">&#8250;</span><a href="{{ route('public.embroidery') }}">Embroidery</a></li>
                            <li><span class="taf-footer-icon">&#8250;</span><a href="{{ route('public.services') }}">Signage &amp; Large Format</a></li>
                            <li><span class="taf-footer-icon">&#8250;</span><a href="{{ route('public.services') }}">Business Printing</a></li>
                            <li><span class="taf-footer-icon">&#8250;</span><a href="{{ route('public.products.index') }}">Promotional Merchandise</a></li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="taf-footer-title">Useful Links</h2>
                        <ul class="taf-footer-services">
                            <li><span class="taf-footer-icon">&#8250;</span><a href="{{ route('public.about') }}">About Us</a></li>
                            <li><span class="taf-footer-icon">&#8250;</span><a href="{{ route('public.portfolio') }}">Our Work</a></li>
                            <li><span class="taf-footer-icon">&#8250;</span><a href="{{ route('public.products.index') }}">Products</a></li>
                            <li><span class="taf-footer-icon">&#8250;</span><a href="{{ $quoteUrl }}">Request a Quote</a></li>
                            <li><span class="taf-footer-icon">&#8250;</span><a href="{{ route('public.contact') }}">Contact</a></li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="taf-footer-title">Contact</h2>
                        <ul class="taf-footer-contact">
                            <li><span class="taf-footer-icon">&#8250;</span><a href="tel:+{{ $sitePhoneRaw }}">{{ $sitePhone }}</a></li>
                            <li><span class="taf-footer-icon">&#8250;</span><a href="mailto:{{ $siteEmail }}">{{ $siteEmail }}</a></li>
                            <li><span class="taf-footer-icon">&#8250;</span><span>{{ $siteContact['address'] ?: 'Nairobi, Kenya' }}</span></li>
                            <li><span class="taf-footer-icon">&#8250;</span><span>Mon–Fri: 8am – 5pm</span></li>
                            <li><span class="taf-footer-icon">&#8250;</span><span>Sat: 8am – 12pm</span></li>
                        </ul>
                        <div class="taf-footer-social">
                            <a href="#" aria-label="Facebook">f</a>
                            <a href="#" aria-label="Instagram">ig</a>
                            <a href="#" aria-label="LinkedIn">in</a>
                        </div>
                    </div>
                </div>
                <div class="taf-footer-copy">&copy; {{ now()->year }} Aurix Branding. Branding, printing, signage, uniforms, packaging, and promotional products across Kenya.</div>
            </div>
        </section>
    </footer>

    <a class="taf-whatsapp-float" href="{{ $siteWhatsappUrl }}" target="_blank" rel="noopener" aria-label="Chat with Aurix Branding on WhatsApp">
        <svg viewBox="0 0 32 32" aria-hidden="true" focusable="false">
            <path fill="currentColor" d="M16.02 3.2c-7.06 0-12.8 5.68-12.8 12.68 0 2.24.6 4.42 1.74 6.34L3.1 29l6.98-1.82a12.9 12.9 0 0 0 5.94 1.46c7.06 0 12.8-5.68 12.8-12.68S23.08 3.2 16.02 3.2Zm0 23.28c-1.9 0-3.76-.5-5.38-1.44l-.38-.22-4.14 1.08 1.1-4.02-.24-.42a10.35 10.35 0 0 1-1.6-5.58c0-5.8 4.78-10.52 10.64-10.52s10.64 4.72 10.64 10.52-4.78 10.6-10.64 10.6Zm5.82-7.88c-.32-.16-1.9-.94-2.2-1.04-.3-.12-.52-.16-.74.16-.22.32-.84 1.04-1.04 1.26-.18.22-.38.24-.7.08-.32-.16-1.36-.5-2.58-1.58-.96-.84-1.6-1.88-1.78-2.2-.18-.32-.02-.5.14-.66.14-.14.32-.38.48-.56.16-.18.22-.32.32-.54.1-.22.06-.4-.02-.56-.08-.16-.74-1.78-1.02-2.44-.26-.64-.54-.56-.74-.56h-.64c-.22 0-.56.08-.86.4-.3.32-1.14 1.1-1.14 2.68s1.18 3.12 1.34 3.34c.16.22 2.32 3.52 5.62 4.94.78.34 1.4.54 1.88.7.8.24 1.52.2 2.08.12.64-.1 1.9-.78 2.16-1.52.26-.74.26-1.38.18-1.52-.08-.14-.28-.22-.6-.38Z"/>
        </svg>
    </a>

    @stack('scripts')
</body>
</html>
