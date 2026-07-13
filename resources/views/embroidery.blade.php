<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Embroidery | Aurix Branding</title>
    <meta name="description" content="Premium Aurix Branding embroidery for uniforms, polos, hoodies, caps, and corporate apparel.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/aurix-branding-logo.png') }}" type="image/png">
    <style>
        :root {
            --gold: #c9942f;
            --gold-light: #f1cf7a;
            --black: #050505;
            --charcoal: #111111;
            --ink: #17140f;
            --muted: #6f675b;
            --line: rgba(23, 20, 15, 0.13);
            --soft: #f7f3ea;
            --ivory: #fffaf1;
        }
        * { box-sizing: border-box; }
        html, body { max-width: 100%; overflow-x: hidden; }
        body { margin: 0; background: var(--soft); color: var(--ink); font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 15px; }
        a { color: inherit; text-decoration: none; }
        button { font: inherit; }
        img { display: block; max-width: 100%; }
        .wrap { width: min(1530px, calc(100% - 56px)); margin: 0 auto; }
        .marquee { overflow: hidden; background: linear-gradient(90deg, #050505, #17140f, #050505); border-bottom: 1px solid rgba(241, 207, 122, 0.32); color: #fffaf1; font-size: 13px; font-weight: 900; letter-spacing: 0.04em; text-transform: uppercase; }
        .marquee-track { display: flex; width: max-content; min-width: 200%; gap: 34px; padding: 9px 0; animation: marquee 28s linear infinite; }
        .marquee span { white-space: nowrap; }
        @keyframes marquee { from { transform: translateX(0); } to { transform: translateX(-50%); } }
        .header { position: sticky; top: 0; z-index: 30; background: rgba(255, 250, 241, 0.96); border-bottom: 1px solid var(--line); backdrop-filter: blur(14px); }
        .nav { display: grid; min-height: 92px; grid-template-columns: 240px minmax(0, 1fr) auto; align-items: center; gap: 22px; }
        .brand { display: inline-flex; min-width: 0; align-items: center; gap: 12px; color: var(--ink); font-size: 18px; font-weight: 900; white-space: nowrap; }
        .brand img { width: 54px; height: 54px; flex: 0 0 54px; border-radius: 2px; object-fit: cover; }
        .brand span { overflow: hidden; text-overflow: ellipsis; }
        .nav-links { display: flex; min-width: 0; justify-content: center; gap: clamp(12px, 1.15vw, 22px); overflow-x: auto; scrollbar-width: none; font-size: 14px; font-weight: 700; white-space: nowrap; }
        .nav-links::-webkit-scrollbar { display: none; }
        .nav-links a.is-active { color: var(--gold); }
        .header-icons { display: flex; gap: 12px; }
        .icon-btn { display: grid; width: 46px; height: 46px; place-items: center; border: 1px solid var(--line); border-radius: 999px; background: #fffaf1; color: var(--ink); }
        .icon-btn svg { width: 21px; height: 21px; }
        .category-ribbon { background: #0c0c0c; color: #fffaf1; }
        .category-ribbon .wrap { display: flex; min-height: 78px; align-items: center; justify-content: space-between; gap: 16px; overflow-x: auto; scrollbar-width: none; }
        .category-ribbon .wrap::-webkit-scrollbar { display: none; }
        .ribbon-item { display: grid; min-width: 78px; justify-items: center; gap: 7px; font-size: 12px; font-weight: 700; }
        .ribbon-icon { display: grid; width: 38px; height: 38px; place-items: center; border-radius: 999px; background: rgba(241, 207, 122, .14); font-size: 18px; }
        .see-all { min-width: 142px; border: 1px solid rgba(241, 207, 122, .46); border-radius: 999px; padding: 12px 20px; text-align: center; font-size: 13px; font-weight: 900; }
        .page { padding: 58px 0 0; }
        .hero-grid { display: grid; grid-template-columns: minmax(0, 1.22fr) minmax(360px, 0.82fr); gap: 34px; align-items: start; }
        .hero-card { min-height: 630px; border-radius: 36px; background: radial-gradient(circle at 82% 16%, rgba(201, 148, 47, 0.22), transparent 34%), linear-gradient(140deg, #050505 0%, #17140f 48%, #2b2518 100%); color: #fffaf1; padding: clamp(28px, 4vw, 58px); box-shadow: 0 28px 70px rgba(23, 20, 15, 0.18); }
        .pill { display: block; max-width: 740px; border-radius: 999px; background: rgba(255, 250, 241, 0.14); padding: 8px 22px; color: #fffaf1; font-size: 14px; font-weight: 900; letter-spacing: .34em; text-transform: uppercase; }
        .hero-card h1 { max-width: 850px; margin: 42px 0 26px; font-size: clamp(3rem, 5.8vw, 5.8rem); line-height: 1.08; letter-spacing: 0; }
        .hero-card h1 span { color: var(--gold-light); }
        .hero-card p { max-width: 850px; margin: 0; color: rgba(255, 250, 241, 0.84); font-size: 19px; line-height: 1.65; }
        .hero-actions { display: flex; flex-wrap: wrap; gap: 18px; margin-top: 48px; }
        .btn { display: inline-flex; min-height: 60px; align-items: center; justify-content: center; border-radius: 999px; padding: 0 34px; font-size: 17px; font-weight: 900; }
        .btn.primary { background: linear-gradient(135deg, var(--gold), var(--gold-light)); color: var(--black); }
        .btn.secondary { border: 1px solid rgba(255, 250, 241, 0.36); color: #fffaf1; }
        .hero-stats { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 24px; margin-top: 76px; }
        .hero-stats strong { display: block; color: #fffaf1; font-size: 24px; }
        .hero-stats span { display: block; margin-top: 6px; color: rgba(255, 250, 241, 0.78); font-size: 16px; }
        .side-stack { display: grid; gap: 24px; }
        .info-card { border: 1px solid var(--line); border-radius: 28px; background: #fffaf1; padding: 30px; box-shadow: 0 18px 48px rgba(23, 20, 15, .06); }
        .eyebrow { margin: 0 0 18px; color: var(--muted); font-size: 14px; font-weight: 700; letter-spacing: .34em; text-transform: uppercase; }
        .info-card h2, .content-card h2 { margin: 0 0 18px; font-size: clamp(1.8rem, 2.5vw, 2.6rem); line-height: 1.15; letter-spacing: 0; }
        .info-card p, .content-card p, .content-card li { color: var(--ink); font-size: 17px; line-height: 1.65; }
        .info-card img { width: 100%; aspect-ratio: 1.8 / 1; margin-top: 26px; border-radius: 20px; object-fit: cover; }
        .section { padding: 70px 0 0; }
        .section-head { max-width: 1000px; margin-bottom: 34px; }
        .section-head h2 { margin: 8px 0 0; font-size: clamp(2.4rem, 4.2vw, 4.8rem); line-height: 1.05; font-weight: 500; }
        .service-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; }
        .service-card { display: grid; min-height: 190px; grid-template-columns: minmax(0, 1fr) 132px; gap: 26px; align-items: center; border: 1px solid var(--line); border-radius: 28px; background: #fffaf1; padding: 28px 32px; box-shadow: 0 18px 48px rgba(23, 20, 15, .06); }
        .service-card h3 { margin: 0 0 14px; font-size: 24px; }
        .service-card p { margin: 0; color: var(--ink); font-size: 17px; line-height: 1.55; }
        .service-card img { width: 112px; height: 112px; border: 4px solid rgba(201, 148, 47, 0.14); border-radius: 999px; object-fit: cover; }
        .split-grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(360px, 1fr); gap: 34px; }
        .content-card { border: 1px solid var(--line); border-radius: 28px; background: #fffaf1; padding: 34px; box-shadow: 0 18px 48px rgba(23, 20, 15, .06); }
        .content-card ul { margin: 22px 0 0; padding-left: 22px; }
        .process-list { display: grid; gap: 22px; }
        .process-item { display: grid; grid-template-columns: 54px minmax(0, 1fr); gap: 20px; align-items: start; border: 1px solid var(--line); border-radius: 18px; background: #ffffff; padding: 22px; }
        .process-item span { color: var(--gold); font-size: 28px; font-weight: 500; }
        .process-item strong { display: block; margin-bottom: 5px; font-size: 19px; }
        .process-item p { margin: 0; }
        .embroidery-examples {
            overflow: hidden;
            border: 1px solid rgba(201, 148, 47, 0.24);
            border-radius: 8px;
            background: #050505;
            box-shadow: 0 28px 70px rgba(23, 20, 15, 0.18);
        }
        .embroidery-examples img {
            width: 100%;
            height: auto;
        }
        .cta { margin: 76px 0 64px; border-radius: 34px; background: linear-gradient(120deg, #2b160f, #111111 58%, #17140f); color: #fffaf1; padding: clamp(30px, 4vw, 48px); }
        .cta h2 { margin: 0 0 18px; font-size: clamp(2rem, 3.4vw, 3.6rem); line-height: 1.12; }
        .cta p { margin: 0; color: rgba(255, 250, 241, 0.82); font-size: 17px; line-height: 1.65; }
        .contact-hero { margin-top: 76px; border-radius: 34px; background: radial-gradient(circle at 80% 20%, rgba(241, 207, 122, 0.16), transparent 34%), linear-gradient(120deg, #050505, #17140f 58%, #2b2518); color: #fffaf1; padding: clamp(30px, 4vw, 48px); box-shadow: 0 28px 70px rgba(23, 20, 15, 0.18); }
        .contact-hero h2 { margin: 42px 0 22px; font-size: clamp(3rem, 5vw, 5.4rem); line-height: 1.05; font-weight: 500; }
        .contact-hero p { max-width: 1040px; margin: 0; color: rgba(255, 250, 241, 0.84); font-size: 19px; line-height: 1.65; }
        .contact-chips { display: flex; flex-wrap: wrap; gap: 16px; margin-top: 40px; }
        .contact-chips a, .contact-chips span { display: inline-flex; min-height: 62px; align-items: center; justify-content: center; border: 1px solid rgba(255, 250, 241, 0.28); border-radius: 999px; padding: 0 30px; color: #fffaf1; font-size: 17px; font-weight: 900; }
        .contact-form-card { margin: 34px auto 0; border: 1px solid var(--line); border-radius: 28px; background: #fffaf1; padding: clamp(26px, 3vw, 44px); box-shadow: 0 18px 48px rgba(23, 20, 15, .08); }
        .contact-form { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; }
        .field { display: grid; gap: 12px; color: #050505; font-size: 17px; font-weight: 700; }
        .field.full { grid-column: 1 / -1; }
        .field input, .field textarea { width: 100%; border: 1px solid rgba(23, 20, 15, 0.16); border-radius: 16px; background: #ffffff; color: var(--ink); padding: 16px 18px; font: inherit; font-size: 16px; outline: 0; transition: border-color .18s ease, box-shadow .18s ease; }
        .field textarea { min-height: 220px; resize: vertical; }
        .field input:focus, .field textarea:focus { border-color: var(--gold); box-shadow: 0 0 0 4px rgba(201, 148, 47, 0.16); }
        .send-btn { width: fit-content; min-height: 60px; border: 0; border-radius: 999px; background: linear-gradient(135deg, var(--gold), var(--gold-light)); color: var(--black); padding: 0 34px; font-size: 17px; font-weight: 900; cursor: pointer; }
        .footer { background: #111111; color: #fffaf1; padding: 48px 0 28px; }
        .footer-grid { display: grid; grid-template-columns: 1.2fr .8fr .8fr 1fr; gap: 34px; }
        .footer h3, .footer h4 { margin: 0 0 14px; }
        .footer p, .footer a, .footer span { display: block; margin: 8px 0 0; color: rgba(255, 250, 241, 0.72); line-height: 1.65; }
        .whatsapp { position: fixed; right: 22px; bottom: 22px; z-index: 80; display: grid; width: 62px; height: 62px; place-items: center; border-radius: 999px; background: #25d366; color: #fff; box-shadow: 0 16px 34px rgba(17, 17, 17, 0.24); }
        .whatsapp svg { width: 36px; height: 36px; }
        @media (max-width: 1180px) {
            .nav { grid-template-columns: 1fr; padding: 18px 0; }
            .nav-links { justify-content: flex-start; }
            .header-icons { display: none; }
            .hero-grid, .split-grid { grid-template-columns: 1fr; }
            .hero-card { min-height: auto; }
            .footer-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 760px) {
            .wrap { width: min(100% - 28px, 1530px); }
            .hero-card { border-radius: 26px; padding: 28px; }
            .hero-card h1 { font-size: 2.65rem; }
            .hero-stats, .service-grid, .footer-grid, .contact-form { grid-template-columns: 1fr; }
            .service-card { grid-template-columns: 1fr; }
            .service-card img { width: 104px; height: 104px; }
            .info-card { padding: 24px; }
            .section-head h2 { font-size: 2.35rem; }
            .contact-hero h2 { font-size: 2.65rem; }
            .field.full { grid-column: auto; }
        }
    </style>
</head>
<body>
    @php
        $contact = $contactSettings ?? \App\Models\SiteSetting::defaultContactSettings();
        $whatsappPhone = '254700816670';
        $displayPhone = '+254 700816670';
        $contactEmail = 'info@aurixbranding.co.ke';
        $whatsappUrl = 'https://wa.me/'.$whatsappPhone.'?text='.rawurlencode('Hello Aurix Branding, I would like an embroidery quote.');
        $tickerText = 'Premium Branding Solutions • Custom T-Shirts • Corporate Gifts • Vehicle Branding • Signage & Roll-Up Banners • Business Cards • Logo Design • High-Quality Printing • Same-Day Printing Available • Nationwide Delivery • Free Quotes';
        $ribbonItems = [
            ['Adventure', '*'], ['Religious', '+'], ['Movies', 'M'], ['Television', 'TV'], ['Sports', 'S'],
            ['Vintage', 'V'], ['Animals', 'A'], ['Funny', 'F'], ['onesies', 'O'], ['Socks', 'K'],
            ['Hoodies', 'H'], ['Bags', 'B'],
        ];
    @endphp

    <div class="marquee" aria-label="Aurix highlights">
        <div class="marquee-track">
            @foreach(range(1, 2) as $repeat)
                <span>{{ $tickerText }}</span>
            @endforeach
        </div>
    </div>

    <header class="header">
        <div class="wrap nav">
            <a href="{{ url('/') }}" class="brand" aria-label="Aurix Branding home">
                <img src="{{ $logoUrl ?: asset('images/aurix-branding-logo.png') }}" alt="Aurix Branding logo">
                <span>Aurix Branding</span>
            </a>
            <nav class="nav-links" aria-label="Main navigation">
                @foreach([
                    'Home' => url('/'),
                    'Shop' => route('public.products.index'),
                    'Men' => route('public.products.index', ['category' => 'men']),
                    'Women' => route('public.products.index', ['category' => 'women']),
                    'Jersey' => route('public.products.index', ['category' => 'jersey']),
                    'Corporate' => route('public.products.index', ['category' => 'corporate']),
                    'Embroidery' => route('public.embroidery'),
                    'Remove background' => '#',
                    'Create Design' => route('public.create-design'),
                    'Maasai' => route('public.products.index', ['category' => 'maasai']),
                ] as $label => $url)
                    <a href="{{ $url }}" @class(['is-active' => $label === 'Embroidery'])>{{ $label }}</a>
                @endforeach
            </nav>
            <div class="header-icons" aria-hidden="true">
                <span class="icon-btn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg></span>
                <span class="icon-btn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.4 0-8 2.2-8 5v1h16v-1c0-2.8-3.6-5-8-5Z"/></svg></span>
                <span class="icon-btn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21s-7-4.4-9.2-8.2C.9 9.6 2.6 6 6.2 6c2 0 3.3 1.1 3.8 2 .5-.9 1.8-2 3.8-2 3.6 0 5.3 3.6 3.4 6.8C19 16.6 12 21 12 21Z"/></svg></span>
                <a class="icon-btn" href="{{ route('public.products.index') }}" aria-label="Open shop"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 18a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm10 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4ZM6.2 6l.5 2h12.7l-1.5 6H8L5.6 3H2v2h2l2.3 11H18v-2H8.4L8 12h11.5L22 6H6.2Z"/></svg></a>
            </div>
        </div>
        <div class="category-ribbon">
            <div class="wrap">
                @foreach($ribbonItems as [$label, $icon])
                    @if($loop->iteration === 9)
                        <a class="see-all" href="{{ route('public.products.index') }}">See All Products</a>
                    @endif
                    <a class="ribbon-item" href="{{ route('public.products.index', ['category' => \Illuminate\Support\Str::slug($label)]) }}">
                        <span class="ribbon-icon">{{ $icon }}</span>
                        <span>{{ $label }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </header>

    <main class="page">
        <section class="wrap hero-grid">
            <div class="hero-card">
                <span class="pill">Embroidery branding</span>
                <h1>Embroidery that elevates your brand in <span>Nairobi and beyond.</span></h1>
                <p>Aurix Branding delivers premium embroidery services for uniforms, caps, polos, hoodies, and corporate apparel. We combine clean digitizing, durable threads, and precise placement to create polished branding that lasts through daily wear.</p>
                <div class="hero-actions">
                    <a href="{{ route('public.embroidery.quote') }}" class="btn primary">Request a Quote</a>
                    <a href="{{ route('public.products.index', ['category' => 'embroidery']) }}" class="btn secondary">View Apparel</a>
                </div>
                <div class="hero-stats">
                    <div><strong>Small or Bulk</strong><span>Flexible order sizes.</span></div>
                    <div><strong>Tailored Fit</strong><span>Made to your brand.</span></div>
                    <div><strong>Regional Reach</strong><span>Nairobi and nationwide.</span></div>
                </div>
            </div>
            <div class="side-stack">
                <article class="info-card">
                    <p class="eyebrow">Why embroidery</p>
                    <h2>Long-lasting, premium branding.</h2>
                    <p>Embroidery gives your brand a polished, tactile finish that resists fading and keeps your logo crisp after repeated wear and washes. Perfect for customer-facing teams, corporate gifting, and retail.</p>
                    <img src="{{ asset('images/aurix-hoodie-category.png') }}" alt="Aurix embroidered hoodie branding">
                </article>
                <article class="info-card">
                    <p class="eyebrow">Service coverage</p>
                    <h2>Built for teams across Kenya.</h2>
                    <p>Whether you need a limited batch for a startup or high-volume uniforms for enterprise teams, we tailor production to your timeline, garment choice, and budget.</p>
                    <img src="{{ asset('images/aurix-branding-collage.png') }}" alt="Aurix embroidery production and branding">
                </article>
            </div>
        </section>

        <section class="wrap section">
            <div class="section-head">
                <p class="eyebrow">Key services</p>
                <h2>Embroidery solutions built for visibility.</h2>
            </div>
            <div class="service-grid">
                <article class="service-card">
                    <div>
                        <h3>Embroidered Patches</h3>
                        <p>Custom patches for uniforms, workwear, and promotional gear. Durable stitching that keeps your logo sharp and consistent across teams.</p>
                    </div>
                    <img src="{{ asset('images/aurix-branding-collage.png') }}" alt="Aurix embroidered patches">
                </article>
                <article class="service-card">
                    <div>
                        <h3>Embroidered Uniforms</h3>
                        <p>Professional uniforms for corporate, hospitality, schools, and institutions with consistent brand placement and premium finishing.</p>
                    </div>
                    <img src="{{ asset('images/aurix-polo-category.png') }}" alt="Aurix embroidered uniforms">
                </article>
                <article class="service-card">
                    <div>
                        <h3>Embroidered Caps & Hats</h3>
                        <p>High-visibility headwear for staff and events. Precision embroidery for bold, readable branding on every cap.</p>
                    </div>
                    <img src="{{ asset('images/aurix-design-categories.png') }}" alt="Aurix embroidered caps">
                </article>
                <article class="service-card">
                    <div>
                        <h3>Custom Embroidered Apparel</h3>
                        <p>Polos, jackets, hoodies, and premium wearables tailored to your brand. Perfect for teams, merchandise, and client gifts.</p>
                    </div>
                    <img src="{{ asset('images/aurix-hoodie-category.png') }}" alt="Aurix custom embroidered apparel">
                </article>
            </div>
        </section>

        <section class="wrap section split-grid">
            <article class="content-card">
                <p class="eyebrow">Brand impact</p>
                <h2>Stand out with professional embroidery.</h2>
                <p>Embroidered branding communicates credibility and quality. Every stitch is aligned to your brand guidelines for a cohesive, professional presentation.</p>
                <ul>
                    <li>Clean, consistent logo reproduction.</li>
                    <li>Premium threads that hold color and shape.</li>
                    <li>Durable finishes for daily wear and long-term use.</li>
                    <li>Placement guidance for polos, caps, hoodies, jackets, and bags.</li>
                </ul>
            </article>
            <article class="content-card">
                <p class="eyebrow">How we work</p>
                <div class="process-list">
                    <div class="process-item"><span>01</span><div><strong>Design & Digitizing</strong><p>We refine your logo and prepare precise embroidery files.</p></div></div>
                    <div class="process-item"><span>02</span><div><strong>Sampling & Approval</strong><p>We test stitch quality and finalize placement with you.</p></div></div>
                    <div class="process-item"><span>03</span><div><strong>Production & Delivery</strong><p>We scale from small to large orders with consistent output.</p></div></div>
                </div>
            </article>
        </section>

        <section class="wrap section">
            <div class="section-head">
                <p class="eyebrow">Embroidery examples</p>
                <h2>High quality embroidery that represents your brand with elegance and durability.</h2>
            </div>
            <div class="embroidery-examples">
                <img src="{{ asset('images/aurix-embroidery-production-collage.png') }}" alt="Aurix embroidery production collage">
            </div>
        </section>

        <section class="wrap cta">
            <p class="eyebrow">Ready to brand</p>
            <h2>Let's build your embroidery identity.</h2>
            <p>Share your logo and project details. Aurix Branding will recommend the best embroidery options for your team, event, or retail line in Nairobi and across Kenya.</p>
            <div class="hero-actions">
                <a href="{{ route('public.embroidery.quote') }}" class="btn primary">Start Your Order</a>
                <a href="tel:+254700816670" class="btn secondary">Talk to a Specialist</a>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="wrap footer-grid">
            <div>
                <h3>Aurix Branding</h3>
                <p>Premium embroidery, apparel branding, print, and signage for teams that need clean, dependable production.</p>
            </div>
            <div>
                <h4>Shop</h4>
                <a href="{{ route('public.products.index', ['category' => 'men']) }}">Men</a>
                <a href="{{ route('public.products.index', ['category' => 'women']) }}">Women</a>
                <a href="{{ route('public.products.index', ['category' => 'kids']) }}">Kids</a>
                <a href="{{ route('public.products.index') }}">Gifts</a>
            </div>
            <div>
                <h4>Company</h4>
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ route('public.products.index') }}">Production</a>
                <a href="{{ route('public.products.index', ['category' => 'corporate']) }}">Corporate</a>
                <a href="{{ route('public.embroidery') }}">Embroidery</a>
            </div>
            <div>
                <h4>Contact</h4>
                <a href="tel:+254700816670">{{ $displayPhone }}</a>
                @if($contactEmail)<a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>@endif
                @if(! empty($contact['address']))<span>{{ $contact['address'] }}</span>@endif
            </div>
        </div>
    </footer>

    <a class="whatsapp" href="{{ $whatsappUrl }}" target="_blank" rel="noopener" aria-label="Chat with Aurix Branding on WhatsApp">
        <svg viewBox="0 0 32 32" aria-hidden="true" focusable="false">
            <path fill="currentColor" d="M16.02 3.2c-7.06 0-12.8 5.68-12.8 12.68 0 2.24.6 4.42 1.74 6.34L3.1 29l6.98-1.82a12.9 12.9 0 0 0 5.94 1.46c7.06 0 12.8-5.68 12.8-12.68S23.08 3.2 16.02 3.2Zm0 23.28c-1.9 0-3.76-.5-5.38-1.44l-.38-.22-4.14 1.08 1.1-4.02-.24-.42a10.35 10.35 0 0 1-1.6-5.58c0-5.8 4.78-10.52 10.64-10.52s10.64 4.72 10.64 10.52-4.78 10.6-10.64 10.6Zm5.82-7.88c-.32-.16-1.9-.94-2.2-1.04-.3-.12-.52-.16-.74.16-.22.32-.84 1.04-1.04 1.26-.18.22-.38.24-.7.08-.32-.16-1.36-.5-2.58-1.58-.96-.84-1.6-1.88-1.78-2.2-.18-.32-.02-.5.14-.66.14-.14.32-.38.48-.56.16-.18.22-.32.32-.54.1-.22.06-.4-.02-.56-.08-.16-.74-1.78-1.02-2.44-.26-.64-.54-.56-.74-.56h-.64c-.22 0-.56.08-.86.4-.3.32-1.14 1.1-1.14 2.68s1.18 3.12 1.34 3.34c.16.22 2.32 3.52 5.62 4.94.78.34 1.4.54 1.88.7.8.24 1.52.2 2.08.12.64-.1 1.9-.78 2.16-1.52.26-.74.26-1.38.18-1.52-.08-.14-.28-.22-.6-.38Z"/>
        </svg>
    </a>
</body>
</html>
