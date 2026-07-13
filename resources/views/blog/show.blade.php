<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->seo_title ?? $post->title }}</title>
    <meta name="description" content="{{ $post->meta_description ?? '' }}">
    <style>
        :root {
            --aurix-ink: #172342;
            --aurix-body: #191b23;
            --aurix-muted: #4b5563;
            --aurix-line: #e7e9ef;
            --aurix-purple: #421983;
            --aurix-orange: #ff642d;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background: #fff;
            color: var(--aurix-body);
            font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            letter-spacing: 0;
        }

        a {
            color: inherit;
        }

        .page-navigation {
            position: sticky;
            top: 0;
            z-index: 30;
            background: #fff;
            box-shadow: 0 8px 30px rgba(16, 24, 40, .08);
        }

        .menu-bar {
            display: grid;
            grid-template-columns: auto auto 1fr auto auto;
            align-items: center;
            gap: 34px;
            min-height: 88px;
            padding: 0 40px;
            color: #334155;
        }

        .brand,
        .menu-link,
        .call-link,
        .audience-link,
        .menu-icon {
            color: #334155;
            text-decoration: none;
        }

        .brand {
            font-size: 27px;
            font-weight: 700;
            letter-spacing: 8px;
            line-height: 1;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .primary-links {
            display: flex;
            align-items: center;
            gap: 36px;
        }

        .menu-link {
            font-size: 18px;
            font-weight: 700;
            line-height: 1;
            white-space: nowrap;
        }

        .menu-link--dropdown::after {
            content: "";
            display: inline-block;
            width: 0;
            height: 0;
            margin-left: 8px;
            vertical-align: middle;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 5px solid currentColor;
        }

        .call-link {
            justify-self: end;
            font-size: 18px;
            font-weight: 400;
        }

        .call-link strong {
            color: var(--aurix-ink);
            font-weight: 700;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .audience-toggle {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 4px;
            border-radius: 8px;
            background: #eef2f7;
        }

        .audience-link {
            min-width: 132px;
            padding: 16px 22px;
            border-radius: 6px;
            font-size: 18px;
            font-weight: 700;
            line-height: 1;
            text-align: center;
        }

        .menu-icon {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: #eef2f7;
        }

        .menu-icon span {
            display: block;
            width: 25px;
            height: 3px;
            border-radius: 3px;
            background: #334155;
        }

        .article-page {
            background: #fff;
            color: var(--aurix-body);
            font-size: 18px;
            line-height: 1.68;
        }

        .article-shell {
            max-width: 1180px;
            margin: 0 auto;
            padding: 34px 20px 72px;
        }

        .article-cta {
            margin: 0 0 48px;
            padding: 34px;
            border-radius: 8px;
            background: var(--aurix-purple);
            color: #fff;
            text-align: center;
        }

        .article-cta h2 {
            margin: 0 0 8px;
            font-size: 30px;
            line-height: 38px;
            font-weight: 800;
        }

        .article-cta p {
            margin: 0 0 20px;
            color: #eee9ff;
            font-size: 17px;
            line-height: 26px;
        }

        .article-cta a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 10px 18px;
            border-radius: 6px;
            background: var(--aurix-orange);
            color: #fff;
            font-size: 16px;
            line-height: 22px;
            font-weight: 800;
            text-decoration: none;
        }

        .article-grid {
            display: grid;
            grid-template-columns: minmax(0, 760px) 300px;
            gap: 72px;
            align-items: start;
        }

        .article-title {
            max-width: 820px;
            margin: 0 0 18px;
            color: #111827;
            font-size: clamp(42px, 5vw, 64px);
            line-height: .98;
            font-weight: 800;
            letter-spacing: 0;
        }

        .article-hero {
            width: 100%;
            margin: 0 0 34px;
            border-radius: 8px;
            overflow: hidden;
            background: #eef1f5;
        }

        .article-hero img {
            display: block;
            width: 100%;
            aspect-ratio: 16 / 9;
            object-fit: cover;
        }

        .article-summary {
            margin: 0 0 32px;
            color: #343946;
            font-size: 21px;
            line-height: 1.55;
            font-weight: 400;
        }

        .article-toc {
            border-top: 1px solid #e6e8ee;
            border-bottom: 1px solid #e6e8ee;
            padding: 22px 0;
            margin: 0 0 34px;
        }

        .article-toc h2 {
            margin: 0 0 14px;
            color: #111827;
            font-size: 20px;
            line-height: 28px;
            font-weight: 800;
        }

        .article-toc ol {
            display: grid;
            gap: 8px;
            margin: 0;
            padding-left: 22px;
            color: #111827;
            font-size: 16px;
            line-height: 24px;
        }

        .article-toc a {
            color: #111827;
            text-decoration: none;
            font-weight: 650;
        }

        .article-toc a:hover,
        .aside-list a:hover {
            color: var(--aurix-orange);
        }

        .article-content {
            color: #242936;
        }

        .article-content h2 {
            margin: 52px 0 18px;
            color: #111827;
            font-size: 34px;
            line-height: 1.18;
            font-weight: 800;
            letter-spacing: 0;
            scroll-margin-top: 94px;
        }

        .article-content h3 {
            margin: 34px 0 14px;
            color: #111827;
            font-size: 25px;
            line-height: 1.28;
            font-weight: 800;
            letter-spacing: 0;
            scroll-margin-top: 94px;
        }

        .article-content h4 {
            margin: 28px 0 12px;
            color: #111827;
            font-size: 21px;
            line-height: 1.28;
            font-weight: 800;
        }

        .article-content p {
            margin: 0 0 20px;
        }

        .article-content a {
            color: #1264d8;
            font-weight: 650;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .article-content ul,
        .article-content ol {
            margin: 0 0 24px;
            padding-left: 28px;
        }

        .article-content li {
            margin-bottom: 10px;
            padding-left: 4px;
        }

        .article-content img {
            display: block;
            width: 100%;
            height: auto;
            margin: 28px 0;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }

        .article-content blockquote {
            margin: 28px 0;
            padding: 22px 26px;
            border-left: 4px solid var(--aurix-orange);
            background: #fff4ee;
            color: #20242f;
            font-size: 19px;
            line-height: 1.58;
        }

        .article-content table {
            display: block;
            width: 100%;
            overflow-x: auto;
            margin: 28px 0;
            border-collapse: collapse;
            font-size: 16px;
            line-height: 24px;
        }

        .article-content th,
        .article-content td {
            border: 1px solid #e5e7eb;
            padding: 13px 15px;
            vertical-align: top;
        }

        .article-content th {
            background: #f5f7fb;
            color: #111827;
            font-weight: 800;
        }

        .article-author {
            display: flex;
            gap: 18px;
            align-items: flex-start;
            margin-top: 52px;
            padding: 26px 0 0;
            border-top: 1px solid #e6e8ee;
        }

        .author-avatar {
            flex: 0 0 58px;
            width: 58px;
            height: 58px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: #111827;
            color: #fff;
            font-size: 18px;
            font-weight: 800;
        }

        .article-author h2 {
            margin: 0 0 6px;
            color: #111827;
            font-size: 20px;
            line-height: 28px;
            font-weight: 800;
        }

        .article-author p {
            margin: 0;
            color: var(--aurix-muted);
            font-size: 15px;
            line-height: 24px;
        }

        .article-aside {
            position: sticky;
            top: 98px;
        }

        .aside-panel {
            border: 1px solid var(--aurix-line);
            border-radius: 8px;
            padding: 22px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(17, 24, 39, .06);
        }

        .aside-panel + .aside-panel {
            margin-top: 18px;
        }

        .aside-panel h2 {
            margin: 0 0 14px;
            color: #111827;
            font-size: 18px;
            line-height: 24px;
            font-weight: 800;
        }

        .aside-list {
            display: grid;
            gap: 10px;
            margin: 0;
            padding: 0;
            list-style: none;
            font-size: 14px;
            line-height: 20px;
        }

        .aside-list a {
            color: #272d39;
            text-decoration: none;
            font-weight: 650;
        }

        .share-row {
            display: flex;
            gap: 8px;
        }

        .share-row a {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border: 1px solid #d9dde6;
            border-radius: 50%;
            color: #111827;
            text-decoration: none;
            font-size: 14px;
            font-weight: 800;
        }

        .site-footer {
            margin-top: 56px;
            color: #fff;
            font-size: 16px;
            line-height: 24px;
        }

        .footer-main {
            position: relative;
            overflow: hidden;
            background: linear-gradient(rgba(0, 0, 0, .84), rgba(0, 0, 0, .84)), #172342;
            padding: 34px 0 28px;
        }

        .footer-container {
            width: min(1180px, calc(100% - 40px));
            margin: 0 auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1fr 1.65fr 1.25fr;
            gap: 48px;
        }

        .footer-title {
            margin: 0 0 16px;
            color: #fff;
            font-size: 22px;
            line-height: 30px;
            font-weight: 700;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            color: #fff;
            text-decoration: none;
        }

        .footer-brand img {
            width: auto;
            height: 54px;
            object-fit: contain;
        }

        .footer-brand strong {
            font-size: 24px;
            line-height: 32px;
        }

        .footer-contact,
        .footer-services {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .footer-contact {
            display: grid;
            gap: 8px;
        }

        .footer-contact li,
        .footer-services li,
        .footer-address {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            color: #fff;
            font-size: 16px;
            line-height: 24px;
        }

        .footer-services {
            columns: 2;
            column-gap: 36px;
            margin-bottom: 18px;
        }

        .footer-services li {
            break-inside: avoid;
            margin: 0 0 10px;
        }

        .footer-services a {
            color: #fff;
            text-decoration: none;
        }

        .footer-services a:hover {
            color: #ffad3d;
        }

        .footer-icon {
            color: #ff8800;
            flex: 0 0 auto;
            margin-top: 1px;
            font-weight: 800;
        }

        .footer-social {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            margin-bottom: 32px;
        }

        .footer-social a {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            display: grid;
            place-items: center;
            background: #ff8800;
            color: #fff;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
        }

        .footer-newsletter {
            display: flex;
            width: 100%;
            max-width: 360px;
        }

        .footer-newsletter input {
            min-width: 0;
            flex: 1;
            height: 42px;
            border: 1px solid #cfd4dc;
            border-radius: 6px 0 0 6px;
            padding: 8px 14px;
            color: #4b5563;
            font-size: 16px;
            line-height: 24px;
        }

        .footer-newsletter button {
            height: 42px;
            border: 0;
            border-radius: 0 6px 6px 0;
            padding: 8px 14px;
            background: #ff8800;
            color: #fff;
            font-size: 16px;
            line-height: 24px;
            cursor: pointer;
        }

        .footer-copy {
            padding-top: 18px;
            color: #d7d7d7;
            font-size: 15px;
            line-height: 22px;
        }

        @media (max-width: 991.98px) {
            .menu-bar {
                grid-template-columns: auto 1fr auto;
                min-height: 76px;
                padding: 0 22px;
                gap: 18px;
            }

            .brand {
                font-size: 23px;
                letter-spacing: 6px;
            }

            .primary-links,
            .call-link,
            .audience-toggle {
                display: none;
            }

            .menu-icon {
                justify-self: end;
            }

            .article-shell {
                padding: 24px 18px 56px;
            }

            .article-grid {
                grid-template-columns: 1fr;
                gap: 34px;
            }

            .article-aside {
                position: static;
                order: -1;
            }

            .article-title {
                font-size: 40px;
                line-height: 1.05;
            }

            .article-summary {
                font-size: 19px;
            }

            .article-content h2 {
                font-size: 29px;
            }

            .article-content h3 {
                font-size: 23px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 34px;
            }

            .footer-services {
                columns: 1;
            }

            .footer-social {
                margin-bottom: 24px;
            }
        }

        @media (max-width: 575.98px) {
            .article-page {
                font-size: 17px;
                line-height: 1.62;
            }

            .article-shell {
                padding-left: 16px;
                padding-right: 16px;
            }

            .article-title {
                font-size: 34px;
            }

            .article-hero img {
                aspect-ratio: 4 / 3;
            }

            .article-author {
                flex-direction: column;
            }

            .article-cta {
                padding: 26px 22px;
            }

            .footer-main {
                padding: 28px 0 24px;
            }

            .footer-newsletter {
                flex-direction: column;
                gap: 10px;
            }

            .footer-newsletter input,
            .footer-newsletter button {
                width: 100%;
                border-radius: 6px;
            }
        }
    </style>
</head>
@php
    $preparedContent = \App\Support\BlogContent::prepare($post->body);
    $toc = $preparedContent['toc'];
    $contact = $contactSettings ?? \App\Models\SiteSetting::defaultContactSettings();
    $phone = $contact['phone'] ?: '+254 745 506 619';
    $whatsappPhone = preg_replace('/\D+/', '', $contact['whatsapp_phone'] ?: $phone);
    $quoteMessage = 'Hello Aurix Branding, I need a quote for '.$post->title.'.';
    $quoteUrl = 'https://wa.me/'.$whatsappPhone.'?text='.rawurlencode($quoteMessage);
    $shareUrl = url()->current();
    $shareTitle = $post->title;
    $authorName = $post->author_name ?? 'Aurix Editorial';
    $authorInitials = collect(explode(' ', $authorName))->filter()->map(fn ($part) => strtoupper(substr($part, 0, 1)))->take(2)->implode('') ?: 'A';
@endphp
<body>
    <nav id="site-navigation" class="page-navigation" role="navigation" aria-label="Primary menu">
        <div class="menu-bar">
            <a class="brand" href="{{ url('/') }}" rel="home" aria-label="Aurix Branding home">AURIX</a>
            <div class="primary-links" aria-label="Service menu">
                <a class="menu-link" href="{{ url('/products') }}">Products</a>
                <a class="menu-link menu-link--dropdown" href="{{ url('/#services') }}">Services</a>
                <a class="menu-link" href="{{ url('/blog/'.$post->slug) }}">Blog</a>
            </div>
            <a class="call-link" href="tel:{{ preg_replace('/\D+/', '', $phone) }}">Call <strong>{{ $phone }}</strong></a>
            <div class="audience-toggle" aria-label="Quick action">
                <a class="audience-link" href="{{ $quoteUrl }}">Get Quote</a>
            </div>
            <a class="menu-icon" href="{{ url('/#contact') }}" title="Menu" aria-label="Open menu"><span></span><span></span><span></span></a>
        </div>
    </nav>

    <main>
        <article class="article-page">
            <div class="article-shell">
                <section class="article-cta">
                    <h2>Book Aurix Branding project</h2>
                    <p>Schedule branding, printing, signage, uniforms, packaging, and promotional product support across Kenya.</p>
                    <a href="{{ $quoteUrl }}">Request quote</a>
                </section>

                <div class="article-grid">
                    <main>
                        <h1 class="article-title">{{ $post->title }}</h1>

                        @if($post->cover_image)
                            <figure class="article-hero">
                                <img src="{{ asset('storage/'.$post->cover_image) }}" alt="{{ $post->image_alt_text ?: $post->title }}">
                            </figure>
                        @endif

                        @if($post->meta_description)
                            <p class="article-summary">{{ $post->meta_description }}</p>
                        @endif

                        @if(count($toc))
                            <section class="article-toc" aria-labelledby="article-overview">
                                <h2 id="article-overview">{{ $post->title }} Guide</h2>
                                <ol>
                                    @foreach($toc as $item)
                                        <li><a href="#{{ $item['id'] }}">{{ $item['text'] }}</a></li>
                                    @endforeach
                                </ol>
                            </section>
                        @endif

                        <div class="article-content">
                            {!! $preparedContent['html'] !!}
                        </div>

                        <section class="article-author" aria-label="Author">
                            <div class="author-avatar">{{ $authorInitials }}</div>
                            <div>
                                <h2>{{ $authorName }}</h2>
                                <p>{{ $readingTime }} min read. Branding, print, signage, packaging, and promotional product guides for businesses in Kenya.</p>
                            </div>
                        </section>
                    </main>

                    <aside class="article-aside" aria-label="Article sidebar">
                        @if(count($toc))
                            <section class="aside-panel">
                                <h2>Table of contents</h2>
                                <ul class="aside-list">
                                    @foreach($toc as $item)
                                        <li><a href="#{{ $item['id'] }}">{{ $item['text'] }}</a></li>
                                    @endforeach
                                </ul>
                            </section>
                        @endif

                        <section class="aside-panel">
                            <h2>Share</h2>
                            <div class="share-row">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" aria-label="Share on Facebook">f</a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($shareUrl) }}" aria-label="Share on LinkedIn">in</a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareTitle) }}" aria-label="Share on X">x</a>
                            </div>
                        </section>
                    </aside>
                </div>
            </div>
        </article>
    </main>

    <footer class="site-footer">
        <section class="footer-main">
            <div class="footer-container">
                <div class="footer-grid">
                    <div>
                        <h2 class="footer-title">CONTACT US</h2>
                        <a class="footer-brand" href="{{ url('/') }}"><img src="{{ asset('images/aurix-branding-logo.png') }}" alt="Aurix Branding logo"></a>
                        <ul class="footer-contact">
                            <li><span class="footer-icon">›</span><span>{{ $phone }}</span></li>
                            @if(!empty($contact['email']))
                                <li><span class="footer-icon">›</span><span>{{ $contact['email'] }}</span></li>
                            @endif
                            <li><span class="footer-icon">›</span><span>Mon-Fri: 8am - 5pm</span></li>
                            <li><span class="footer-icon">›</span><span>Sat: 8am - 12pm</span></li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="footer-title">Our Services</h2>
                        <ul class="footer-services">
                            <li><span class="footer-icon">›</span><a href="{{ url('/products') }}">Printed Products</a></li>
                            <li><span class="footer-icon">›</span><a href="{{ url('/#services') }}">Brand Strategy</a></li>
                            <li><span class="footer-icon">›</span><a href="{{ url('/#services') }}">Signage</a></li>
                            <li><span class="footer-icon">›</span><a href="{{ url('/#services') }}">Uniform Branding</a></li>
                            <li><span class="footer-icon">›</span><a href="{{ url('/#services') }}">Packaging</a></li>
                            <li><span class="footer-icon">›</span><a href="{{ $quoteUrl }}">Quote Request</a></li>
                            <li><span class="footer-icon">›</span><a href="{{ url('/blog/'.$post->slug) }}">Branding Guides</a></li>
                            <li><span class="footer-icon">›</span><a href="{{ url('/') }}">Aurix Branding</a></li>
                        </ul>
                        <h2 class="footer-title">Our Office Address</h2>
                        <div class="footer-address"><span class="footer-icon">›</span><span>{{ $contact['address'] ?: 'Nairobi, Kenya. Branding and printing support available across Kenya.' }}</span></div>
                    </div>
                    <div>
                        <h2 class="footer-title">Find Us On Social Media</h2>
                        <div class="footer-social">
                            <a href="#" aria-label="Facebook">f</a>
                            <a href="#" aria-label="Twitter">x</a>
                            <a href="#" aria-label="Instagram">ig</a>
                            <a href="#" aria-label="LinkedIn">in</a>
                        </div>
                        <h2 class="footer-title">Signup To Our Newsletter</h2>
                        <form class="footer-newsletter" action="{{ url('/') }}" method="get">
                            <input type="email" name="email" placeholder="Email Address..." aria-label="Email Address">
                            <button type="submit">Subscribe!</button>
                        </form>
                    </div>
                </div>
                <div class="footer-copy">© {{ now()->year }} Aurix Branding. Branding, printing, signage, uniforms, packaging, and promotional products across Kenya.</div>
            </div>
        </section>
    </footer>
</body>
</html>
