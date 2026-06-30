<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Aurix Branding</title>
        <meta name="description" content="Aurix Branding provides business cards, flyers, banners, signage, branded apparel, and promotional products with nationwide delivery.">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="preconnect" href="https://naiprinters.co.ke" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="icon" href="{{ asset('images/aurix-mark.svg') }}" type="image/svg+xml">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="aurix-page">
        @php
            $assetBase = 'https://naiprinters.co.ke';
            $categories = [
                ['name' => 'Banners', 'href' => '/Banners', 'image' => '/storage/media-library/DnFPnNQR1k6VMcpEpywCvt3BFzmAwbEnax0ywKop.jpg'],
                ['name' => 'Business Cards', 'href' => '/flyers-posters', 'image' => '/storage/media-library/om47dlzLTyw1w5x6zYITYxOkLyUImobXJDdKQYyL.jpg'],
                ['name' => 'Posters', 'href' => '/flyers-posters', 'image' => '/storage/media-library/mftQ0gnr88XpOPn7Q1q1Mbbu6zIewUy2wynh3AQU.jpg'],
                ['name' => 'Brochures', 'href' => '/products', 'image' => '/storage/media-library/WTWxzKuUU0eJbzVWCMJgthfA3cSs7EQ8jtpazyj4.png'],
                ['name' => 'New products', 'href' => '/products', 'image' => '/storage/media-library/vcwO607a80yVPosKoaJDe8TTghzXiidTi71bZcKR.jpg'],
            ];
            $showcases = [
                ['title' => 'Promotional items', 'copy' => 'Mugs | Keychains | Tote Bags | Water Bottles | Notebooks | Stickers | Calendars | USB Drives | Lanyards | Caps | Mouse Pads', 'image' => '/storage/media-library/sr3lAsBIi4SDPydesVSZbmEua7wnbbEuLtyJKzWg.jpg'],
                ['title' => 'Clothing & textiles', 'copy' => 'Printed apparel and textile products for staff uniforms, teams, and campaigns.', 'image' => '/storage/media-library/gPxJcSfQyNq800mYR7L9ShbOa9v14tFT9EllYXfN.jpg'],
                ['title' => 'Promotional pens', 'copy' => 'Affordable branded pens for conferences, offices, and bulk promotional orders.', 'image' => '/storage/media-library/4jUx2BpJMriKZjWrBbfxnWvzqpcUVJPhJpyTi46K.jpg'],
                ['title' => 'Exhibition systems', 'copy' => 'Portable display solutions for trade shows, activations, and branded event spaces.', 'image' => '/storage/media-library/NaZq8zCk019PRzyVTdp7smSNOXIMSXYQbQW8Blm8.png'],
            ];
            $products = [
                ['cat' => 'Marketing Collateral and Publications', 'name' => 'Bookmark Printing', 'price' => '940', 'usd' => '$7.46', 'image' => '/storage/product-thumbnails/uisIseUVxtj8lpFmuS7I4ogHJoPthbJ6wmjGbS6C.jpg'],
                ['cat' => 'Promotional Items', 'name' => 'Branded lanyard Printing', 'price' => '450', 'usd' => '$3.57', 'image' => '/storage/product-thumbnails/RB22IMcehGJedRgMrsuo8lzCbXuoCGJs7akE1NQn.png'],
                ['cat' => 'Promotional Items', 'name' => 'Wheel Cover Printing', 'price' => '5,300', 'usd' => '$42.06', 'image' => '/storage/product-thumbnails/ePU6gOQ5z5V9GdTw0GgEn41PEnEQmmk3qSxlu1hv.png'],
                ['cat' => 'Brochures', 'name' => 'Brochure', 'price' => '50', 'usd' => '$0.40', 'image' => '/storage/product-thumbnails/U45CKAn2kNHU8H3ZtsYUrlE5XBYWO7ujw0JPQWEm.jpg'],
                ['cat' => 'Rollup Banner', 'name' => 'Rollup Banner', 'price' => '8,700', 'usd' => '$69.05', 'image' => '/storage/product-thumbnails/qV1hP9lRiIeXcN8Bu9tagqfUTf8RuBY59LjUXjgg.jpg'],
                ['cat' => 'Business cards', 'name' => 'Business cards', 'price' => '10', 'usd' => '$0.08', 'image' => '/storage/product-thumbnails/GLhAqU3GevIf2xpwSMaLB1tsLmZxYLO2eyVI2lvS.jpg'],
                ['cat' => 'Banners', 'name' => 'Door Framed Banner', 'price' => '5,500', 'usd' => '$43.65', 'image' => '/storage/product-thumbnails/bpfq3eiqMReNj7ueEo7Gi7UiuQhkxiD3dappgCr1.webp'],
                ['cat' => 'Banners', 'name' => 'Backdrop Banner Printing', 'price' => '25,500', 'usd' => '$202.38', 'image' => '/storage/product-thumbnails/d6b773c7kaqhEp9mneuHnaKeSrzg06GR79RJhcKC.jpg'],
            ];
            $servicesCards = [
                ['small' => 'Just finding the right material?', 'title' => 'Samples of paper and more that you can touch', 'href' => '/products', 'image' => '/storage/media-library/Ob01Ew5pXcZQazwVA781anPrRCRchZoMAspiiaF8.jpg'],
                ['small' => 'No graphics software on your PC?', 'title' => 'let our Graphics team handle it for you.', 'href' => '/design-services', 'image' => '/storage/media-library/pY1YGRLo8hEZ7H8K1LcfWHMpjaMNzwdFr3FOtjTR.png'],
                ['small' => 'Do you have questions or wishes?', 'title' => 'Simply contact us by phone, via e-mail or chat!', 'href' => '/contact', 'image' => '/storage/media-library/8lDl8XfUvQPKHuk4EcCYznFCxyZgkOk9F5tbgqJp.jpg'],
            ];
            $favourites = [
                ['name' => 'Bags', 'icon' => '/storage/media-library/blAadlyvjfYisJc7kTbQ3KaKGe4mNx5utdFy0NJQ.png'],
                ['name' => 'Boards/Signs', 'icon' => '/storage/media-library/oZrSkMf3irlYKDeJJdmYkBytswXLFlaiUpgBKQMz.png'],
                ['name' => 'Brochures', 'icon' => '/storage/media-library/HiBDaYKJgOE5S7NIRxAXwwTvwCDwytF7mkZaSKB9.png'],
                ['name' => 'Business cards', 'icon' => '/storage/media-library/7Tnc9gzsTZFSxikfhzypP3ENLVMidknp3u5Jv6L1.png'],
                ['name' => 'Banners', 'icon' => '/storage/media-library/AUxJpO0wTSu5uXxZS5I2ctKg3A4kRqJKPBZkxiXM.png'],
            ];
        @endphp

        <div class="aurix-top-strip">
            <div class="aurix-wrap">
                <span>Free standard shipping</span>
                <span>15 years of experience</span>
                <span>Our own production</span>
                <a href="https://wa.me/254745506619?text=Hello%20Aurix%20Branding%2C%20I%20need%20a%20quote.">Live Chat</a>
            </div>
        </div>

        <header class="aurix-header">
            <div class="aurix-wrap aurix-header-main">
                <a href="/" class="aurix-brand" aria-label="Aurix Branding home">
                    <img src="{{ asset('images/aurix-mark.svg') }}" alt="">
                    <span>Aurix Branding</span>
                </a>
                <button class="aurix-what-trigger" type="button">What We Print <span>⌄</span></button>
                <form class="aurix-search" action="/products" method="get">
                    <input name="q" type="search" placeholder="Search...">
                    <button type="submit" aria-label="Search">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 6 16.65a7.5 7.5 0 0 0 10.65 0Z"/></svg>
                    </button>
                </form>
                <nav class="aurix-header-actions" aria-label="Account">
                    <a href="/login">Login</a>
                    <a class="aurix-quick-btn" href="/products">Quick Quote</a>
                    <a href="/cart">Shopping Cart</a>
                    <a href="#">Country</a>
                </nav>
            </div>
        </header>

        <nav class="aurix-category-nav" aria-label="Product categories">
            <div class="aurix-wrap">
                @foreach(['All products', 'Brochures', 'Flyers & Leaflets', 'Posters', 'Trade show & Advertising', 'Business cards & Cards', 'Office supplies', 'Stickers', 'Promotional items', 'Services'] as $item)
                    <a href="/products">{{ $item }}</a>
                @endforeach
            </div>
        </nav>

        <main>
            <section class="pet-promo-slide" aria-label="With Aurix Branding">
                <div class="pet-promo-background"></div>
                <img class="pet-promo-dog" src="{{ $assetBase }}/storage/media-library/ZlMZs8eN5i34Q6xOdkGhAqUZ1Sh2tfBIlJ11lqu3.png" alt="Online printing">
                <div class="pet-promo-content">
                    <div class="pet-promo-icons">▼ · ♣ · ▼</div>
                    <h1><span>Online</span> printing</h1>
                    <p class="pet-promo-subtitle">With Aurix Branding</p>
                    <p class="pet-promo-copy">Ideal for business cards, flyers, banners, and branded apparel with nationwide delivery</p>
                    <a class="pet-promo-button" href="/products">Print Now</a>
                </div>
                <div class="pet-promo-products" aria-hidden="true">
                    <img src="{{ $assetBase }}/storage/media-library/CsoceV7QRBwRhuWCHHEiM8qm845tbT4YLmjrguSE.png" alt="">
                </div>
            </section>

            <section class="home-wrap">
                <div class="section-head-row">
                    <h2>Top categories</h2>
                    <a href="/products">SHOW ALL</a>
                </div>
                <div class="thumb-grid-5">
                    @foreach($categories as $category)
                        <a href="{{ $category['href'] }}" class="top-category-card">
                            <img src="{{ $assetBase }}{{ $category['image'] }}" alt="{{ $category['name'] }}">
                            <span>{{ $category['name'] }}</span>
                        </a>
                    @endforeach
                </div>
            </section>

            <section class="home-wrap home-card-block">
                <h2>Discover our huge variety of products</h2>
                <div class="thumb-grid-4">
                    @foreach($showcases as $showcase)
                        <a href="/products" class="product-showcase-card">
                            <div><img src="{{ $assetBase }}{{ $showcase['image'] }}" alt="{{ $showcase['title'] }}"></div>
                            <h3>{{ $showcase['title'] }}</h3>
                            <p>{{ $showcase['copy'] }}</p>
                        </a>
                    @endforeach
                </div>
            </section>

            <section class="top-picks-section">
                <div class="top-picks-inner">
                    <div class="top-picks-header">
                        <h2>Best Selling</h2>
                        <a href="/products">All Products ›</a>
                    </div>
                    <div class="top-picks-row">
                        @foreach($products as $product)
                            <a href="/products" class="top-pick-card">
                                <div class="top-pick-media">
                                    <span>{{ $product['cat'] }}</span>
                                    <img src="{{ $assetBase }}{{ $product['image'] }}" alt="{{ $product['name'] }}">
                                </div>
                                <div class="top-pick-body">
                                    <h3>{{ $product['name'] }}</h3>
                                    <div class="top-pick-footer">
                                        <span class="price"><b>KES</b> {{ $product['price'] }} <em>{{ $product['usd'] }}</em></span>
                                        <span class="order">Order Now</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="home-wrap home-card-block">
                <h2>Discover our services</h2>
                <div class="thumb-grid-3">
                    @foreach($servicesCards as $service)
                        <a href="{{ $service['href'] }}" class="service-card">
                            <img src="{{ $assetBase }}{{ $service['image'] }}" alt="{{ $service['title'] }}">
                            <div>
                                <p>{{ $service['small'] }}</p>
                                <h3>{{ $service['title'] }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>

            <section class="home-wrap home-card-block">
                <a href="/products?q=offset%20printing" class="bulk-banner">
                    <strong>Bulk Printing <span>20% OFF</span></strong>
                    <p>Premium offset printing for flyers, brochures, books, magazines, posters and packaging. Sharp colour, bulk-ready quality.</p>
                    <b>Order Prints Now</b>
                </a>
                <h2>Find your favourite product</h2>
                <div class="icon-grid-5">
                    @foreach($favourites as $favourite)
                        <a href="/products" class="favourite-card">
                            <img src="{{ $assetBase }}{{ $favourite['icon'] }}" alt="{{ $favourite['name'] }} icon">
                            <span>{{ $favourite['name'] }}</span>
                        </a>
                    @endforeach
                </div>
                <div class="show-all"><a href="/products">Show all categories</a></div>
            </section>

            <section class="quote-section">
                <div class="quote-card">
                    <div class="quote-head">
                        <h2>Didn't find what you were looking for?</h2>
                        <p>Tell us what you need and our team will get back to you.</p>
                    </div>
                    <form class="quote-form" action="/contact" method="post">
                        @csrf
                        <fieldset>
                            <legend>I am looking for...</legend>
                            <div class="checks">
                                @foreach(['Shop board / logo signage', 'Office or wall branding', 'Posters / banners', 'Stickers / labels', 'Brochures / fliers', 'Exhibition or custom request'] as $solution)
                                    <label><input type="checkbox" name="solutions[]" value="{{ $solution }}"> {{ $solution }}</label>
                                @endforeach
                            </div>
                        </fieldset>
                        <label>Message <textarea name="message" rows="3" placeholder="Tell us what you need."></textarea></label>
                        <div class="form-grid">
                            <label>Name <span>*</span><input name="name" required></label>
                            <label>Business Name <input name="business_name" placeholder="Company Name"></label>
                            <label>Phone <span>*</span><input name="phone" required placeholder="+254"></label>
                            <label>Email <span>*</span><input type="email" name="email" required></label>
                        </div>
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </section>
        </main>

        <footer class="aurix-site-footer">
            <div class="aurix-wrap footer-grid">
                <div>
                    <h3>Aurix Branding</h3>
                    <p>Custom printing at scale with fast turnaround and design-friendly workflows.</p>
                    <button type="button" data-printing-agent-button>Register as Our Printing Agent</button>
                    <p class="agent-status" hidden data-printing-agent-status>Coming soon!</p>
                </div>
                <div><h4>Company</h4><a href="/about">About Us</a><a href="/contact">Contact</a><a href="/blog">Blog</a></div>
                <div><h4>Support</h4><a href="/help">Help Center</a><a href="/upload-artwork">Artwork Upload</a><a href="/checkout">Checkout</a></div>
                <div><h4>Trust</h4><p>ISO-grade print quality</p><p>Nationwide delivery</p><p>Eco-friendly paper options</p></div>
            </div>
            <div class="aurix-site-footer-bottom">© {{ now()->year }} Aurix Branding. All rights reserved.</div>
        </footer>

        <div class="aurix-whatsapp-widget is-visible" data-whatsapp-widget>
            <div class="aurix-whatsapp-card">
                <span><img src="{{ $assetBase }}/storage/site/xXonVZhS1Ttq3wYzC1aTVUbG9gaYMbnmt4evftzX.png" alt=""></span>
                <div><p>Aurix Branding</p><strong>Hi, how can we help?</strong></div>
                <button type="button" aria-label="Close WhatsApp message" data-whatsapp-close>×</button>
            </div>
            <a href="https://wa.me/254745506619?text=Hello%20Aurix%20Branding%2C%20I%20need%20a%20quote." class="aurix-whatsapp-button" aria-label="WhatsApp">
                <svg viewBox="0 0 64 64" fill="currentColor"><path d="M32 8C18.75 8 8 17.82 8 29.94c0 7.1 3.69 13.42 9.41 17.43L15.8 56l8.71-4.65A26.33 26.33 0 0 0 32 51.88c13.25 0 24-9.82 24-21.94S45.25 8 32 8Z"/><circle cx="23.5" cy="30.5" r="3.2" fill="#078b19"/><circle cx="32" cy="30.5" r="3.2" fill="#078b19"/><circle cx="40.5" cy="30.5" r="3.2" fill="#078b19"/></svg>
            </a>
        </div>
    </body>
</html>
