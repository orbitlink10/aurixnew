<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Aurix Brand Studio') }}</title>
        <meta name="description" content="Aurix is a Kenyan branding studio shaping bold identities, packaging, and digital experiences for growing businesses across East Africa.">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700|fraunces:500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .slider-shell { position: relative; overflow: hidden; border-radius: 24px; box-shadow: 0 18px 40px rgba(15,23,42,0.16); }
            .slider-track { display: flex; transition: transform 0.7s ease; }
            .slide { min-width: 100%; position: relative; }
            .slide img { width: 100%; height: 360px; object-fit: cover; display: block; }
            .slide-overlay { position: absolute; inset: 0; background: linear-gradient(90deg, rgba(15,23,42,0.55) 0%, rgba(15,23,42,0.05) 70%); color: #fff; padding: 32px; display: flex; flex-direction: column; justify-content: flex-end; }
            .slide-dots { position: absolute; bottom: 14px; right: 18px; display: flex; gap: 8px; }
            .slide-dots button { width: 10px; height: 10px; border-radius: 999px; border: none; background: rgba(255,255,255,0.6); cursor: pointer; transition: all 0.2s; }
            .slide-dots button.active { width: 24px; background: #22d3ee; }
        </style>
    </head>
    <body>
        <div class="page">
            <header class="site-header">
                <div class="container nav">
                    <a class="brand" href="#top" aria-label="Aurix home" data-cursor="Home" data-magnetic>
                        <img class="brand-mark" src="/images/aurix-mark.svg" alt="" width="28" height="28" aria-hidden="true">
                        <span class="brand-name">Aurix</span>
                    </a>
                    <nav class="nav-links" aria-label="Primary">
                        <a href="#work" data-magnetic>Work</a>
                        <a href="#services" data-magnetic>Services</a>
                        <a href="#branding" data-magnetic>Branding</a>
                        <a href="#process" data-magnetic>Process</a>
                        <a href="#insights" data-magnetic>Insights</a>
                    </nav>
                    <div class="nav-actions">
                        <a class="btn btn-secondary" href="#contact" data-cursor="Start" data-magnetic>Start a project</a>
                    </div>
                </div>
            </header>

            <main id="top">
                @if(isset($slides) && $slides->count())
                <section class="section" style="padding-top:24px;">
                    <div class="container">
                        <div class="slider-shell" x-data="{ current: 0, total: {{ $slides->count() }} }" x-init="setInterval(()=>{ current = (current+1)%total; }, 2000)">
                            <div class="slider-track" :style="`transform: translateX(-${current * 100}%);`">
                                @foreach($slides as $slide)
                                    <div class="slide">
                                        @if($slide->image_url)
                                            <img src="{{ $slide->image_url }}" alt="{{ $slide->title ?? 'Slide' }}">
                                        @endif
                                        <div class="slide-overlay">
                                            @if($slide->title)
                                                <p class="eyebrow" style="color:#a5f3fc;">{{ $slide->title }}</p>
                                            @endif
                                            @if($slide->caption)
                                                <h3 class="section-title" style="color:#fff; margin: 4px 0 8px;">{{ $slide->caption }}</h3>
                                            @endif
                                            @if($slide->button_text && $slide->button_url)
                                                <a href="{{ $slide->button_url }}" class="btn" style="align-self:flex-start;">{{ $slide->button_text }}</a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="slide-dots">
                                @foreach($slides as $index => $slide)
                                    <button :class="current === {{ $index }} ? 'active' : ''" @click="current={{ $index }}"></button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
                @endif

                <section class="hero">
                    <div class="container hero-grid">
                        <div class="hero-copy">
                            <p class="hero-kicker reveal" style="--delay: 0.05s;">Aurix Branding Studio</p>
                            <h1 class="hero-title reveal" style="--delay: 0.15s;">Build a brand people trust.</h1>
                            <p class="hero-subtitle reveal" style="--delay: 0.22s;">Strategy-led identity, packaging, and digital design for ambitious teams across East Africa.</p>
                            <p class="hero-lead reveal" style="--delay: 0.3s;">We translate your story into a cohesive system - visuals, messaging, and UI - so every touchpoint feels premium and consistent.</p>
                            <div class="hero-actions reveal" style="--delay: 0.35s;">
                                <a class="btn" href="#contact" data-cursor="Book" data-magnetic>Book a discovery call</a>
                                <a class="btn btn-ghost" href="#work" data-cursor="View" data-magnetic>See case studies</a>
                            </div>
                            <div class="hero-stats reveal" style="--delay: 0.45s;">
                                <div>
                                    <h3>80+</h3>
                                    <p>Brand launches across Kenya</p>
                                </div>
                                <div>
                                    <h3>6 weeks</h3>
                                    <p>Average end-to-end turnaround</p>
                                </div>
                                <div>
                                    <h3>14</h3>
                                    <p>Industries served in East Africa</p>
                                </div>
                            </div>
                        </div>
                        <div class="hero-visual reveal" style="--delay: 0.2s;">
                            <img class="hero-image" src="/images/hero-showcase.svg" alt="Aurix brand system preview" loading="eager">
                            <div class="hero-chip hero-chip-top" aria-hidden="true">Strategy • Identity • Packaging • Digital</div>
                            <div class="hero-chip hero-chip-bottom" aria-hidden="true">Brand kits delivered in 6-8 weeks</div>
                        </div>
                    </div>
                </section>

                <section class="trusted">
                    <div class="container">
                        <p class="trusted-label reveal" style="--delay: 0.1s;">Trusted by ambitious Kenyan teams</p>
                        <div class="trusted-grid reveal" style="--delay: 0.2s;">
                            <span>Ndoto Coffee</span>
                            <span>Lakeview Labs</span>
                            <span>Safari Trail Hotels</span>
                            <span>Kibera Makers</span>
                            <span>Orbit Health</span>
                        </div>
                    </div>
                </section>

                <section id="services" class="section">
                    <div class="container">
                        <div class="section-head">
                            <div>
                                <p class="eyebrow reveal" style="--delay: 0.1s;">Services</p>
                                <h2 class="section-title reveal" style="--delay: 0.2s;">A full-stack brand team, without the overhead.</h2>
                            </div>
                            <p class="section-lead reveal" style="--delay: 0.3s;">Clear strategy, a tight visual system, and delivery-ready files your team can use immediately - from print to product.</p>
                        </div>
                        <div class="cards-grid">
                            <article class="card reveal" style="--delay: 0.1s;">
                                <img class="card-icon" src="/images/icons/strategy.svg" alt="" aria-hidden="true" loading="lazy">
                                <h3>Brand strategy</h3>
                                <p>Positioning, messaging, and differentiation tuned for Kenyan audiences.</p>
                                <ul class="card-list">
                                    <li>Workshop + research</li>
                                    <li>Messaging &amp; tone</li>
                                    <li>Go-to-market story</li>
                                </ul>
                            </article>
                            <article class="card reveal" style="--delay: 0.2s;">
                                <img class="card-icon" src="/images/icons/identity.svg" alt="" aria-hidden="true" loading="lazy">
                                <h3>Visual identity</h3>
                                <p>Logo systems, typography, and colors that translate from billboards to apps.</p>
                                <ul class="card-list">
                                    <li>Logo suite</li>
                                    <li>Typography &amp; palette</li>
                                    <li>Brand guidelines</li>
                                </ul>
                            </article>
                            <article class="card reveal" style="--delay: 0.3s;">
                                <img class="card-icon" src="/images/icons/packaging.svg" alt="" aria-hidden="true" loading="lazy">
                                <h3>Packaging + retail</h3>
                                <p>Packaging, wayfinding, and in-store brand cues that drive shelf presence.</p>
                                <ul class="card-list">
                                    <li>Packaging system</li>
                                    <li>Print-ready files</li>
                                    <li>Retail rollout kit</li>
                                </ul>
                            </article>
                            <article class="card reveal" style="--delay: 0.4s;">
                                <img class="card-icon" src="/images/icons/digital.svg" alt="" aria-hidden="true" loading="lazy">
                                <h3>Digital experiences</h3>
                                <p>Web and product design for experiences that feel seamless on mobile.</p>
                                <ul class="card-list">
                                    <li>Website UI</li>
                                    <li>Design systems</li>
                                    <li>Handoff + QA</li>
                                </ul>
                            </article>
                        </div>
                    </div>
                </section>

                <section id="branding" class="section gallery">
                    <div class="container">
                        <div class="section-head">
                            <div>
                                <p class="eyebrow reveal" style="--delay: 0.1s;">Branding assets</p>
                                <h2 class="section-title reveal" style="--delay: 0.2s;">A system you can deploy everywhere.</h2>
                            </div>
                            <p class="section-lead reveal" style="--delay: 0.3s;">We deliver clean files and a consistent visual language - ready for social, packaging, signage, and digital UI.</p>
                        </div>

                        <div class="gallery-grid">
                            <figure class="gallery-item reveal" style="--delay: 0.1s;">
                                <img class="gallery-image" src="/images/brand-kit.svg" alt="Brand kit layout preview" loading="lazy">
                                <figcaption>
                                    <h3>Brand kit</h3>
                                    <p>Guidelines, templates, and usage rules.</p>
                                </figcaption>
                            </figure>
                            <figure class="gallery-item reveal" style="--delay: 0.2s;">
                                <img class="gallery-image" src="/images/packaging.svg" alt="Packaging layout preview" loading="lazy">
                                <figcaption>
                                    <h3>Packaging</h3>
                                    <p>Print-ready systems with shelf impact.</p>
                                </figcaption>
                            </figure>
                            <figure class="gallery-item reveal" style="--delay: 0.3s;">
                                <img class="gallery-image" src="/images/web-ui.svg" alt="Web UI layout preview" loading="lazy">
                                <figcaption>
                                    <h3>Web UI</h3>
                                    <p>Modern interfaces built for mobile.</p>
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                </section>

                <section id="work" class="section work">
                    <div class="container">
                        <div class="section-head">
                            <div>
                                <p class="eyebrow reveal" style="--delay: 0.1s;">Selected work</p>
                                <h2 class="section-title reveal" style="--delay: 0.2s;">Case studies built on momentum, not vanity.</h2>
                            </div>
                            <p class="section-lead reveal" style="--delay: 0.3s;">We measure success in growth markers like sign-ups, retention, and customer recall.</p>
                        </div>
                        <div class="case-grid">
                            <article class="case-card reveal" style="--delay: 0.1s;">
                                <div class="case-meta">Retail / Nairobi</div>
                                <img class="case-thumb" src="/images/work/kifaru.svg" alt="" aria-hidden="true" loading="lazy">
                                <h3>Kifaru Outdoor Gear</h3>
                                <p>Unified brand system for new stores and ecommerce rollout.</p>
                                <div class="case-metrics">
                                    <span>+38% repeat buyers</span>
                                    <span>12 store kits</span>
                                </div>
                            </article>
                            <article class="case-card reveal" style="--delay: 0.2s;">
                                <div class="case-meta">Fintech / Kisumu</div>
                                <img class="case-thumb" src="/images/work/pesalink.svg" alt="" aria-hidden="true" loading="lazy">
                                <h3>PesaLink Partners</h3>
                                <p>Brand refresh and app UI for a youth-first wallet.</p>
                                <div class="case-metrics">
                                    <span>2x sign-ups</span>
                                    <span>45k new users</span>
                                </div>
                            </article>
                            <article class="case-card reveal" style="--delay: 0.3s;">
                                <div class="case-meta">Hospitality / Mombasa</div>
                                <img class="case-thumb" src="/images/work/coastal.svg" alt="" aria-hidden="true" loading="lazy">
                                <h3>Coastal Haven Resorts</h3>
                                <p>Repositioned luxury boutique stays to international travelers.</p>
                                <div class="case-metrics">
                                    <span>+29% bookings</span>
                                    <span>7 brand touchpoints</span>
                                </div>
                            </article>
                        </div>
                    </div>
                </section>

                <section id="process" class="section process">
                    <div class="container">
                        <div class="section-head">
                            <div>
                                <p class="eyebrow reveal" style="--delay: 0.1s;">Process</p>
                                <h2 class="section-title reveal" style="--delay: 0.2s;">A focused, collaborative path from story to system.</h2>
                            </div>
                            <p class="section-lead reveal" style="--delay: 0.3s;">Clear checkpoints, weekly reviews, and delivery-ready files for your internal team or agency.</p>
                        </div>
                        <ol class="process-grid">
                            <li class="process-step reveal" style="--delay: 0.1s;">
                                <span class="step-num">01</span>
                                <h3>Discover</h3>
                                <p>Market research, stakeholder interviews, and brand audit.</p>
                            </li>
                            <li class="process-step reveal" style="--delay: 0.2s;">
                                <span class="step-num">02</span>
                                <h3>Define</h3>
                                <p>Positioning, voice, and story narrative built for local resonance.</p>
                            </li>
                            <li class="process-step reveal" style="--delay: 0.3s;">
                                <span class="step-num">03</span>
                                <h3>Design</h3>
                                <p>Identity, layouts, and digital components with system thinking.</p>
                            </li>
                            <li class="process-step reveal" style="--delay: 0.4s;">
                                <span class="step-num">04</span>
                                <h3>Deliver</h3>
                                <p>Launch kits, brand guidelines, and rollout support.</p>
                            </li>
                        </ol>
                    </div>
                </section>

                <section id="insights" class="section insights">
                    <div class="container">
                        <div class="section-head">
                            <div>
                                <p class="eyebrow reveal" style="--delay: 0.1s;">Insights</p>
                                <h2 class="section-title reveal" style="--delay: 0.2s;">Signals we track across East Africa.</h2>
                            </div>
                            <p class="section-lead reveal" style="--delay: 0.3s;">We share field notes and data snapshots so your team stays ahead of changing customer expectations.</p>
                        </div>
                        <div class="insights-grid">
                            <article class="insight reveal" style="--delay: 0.1s;">
                                <h3>Retail visibility</h3>
                                <p>Shoppers spend under 6 seconds deciding between competing shelves. Strong color contrast wins attention.</p>
                            </article>
                            <article class="insight reveal" style="--delay: 0.2s;">
                                <h3>Mobile-first trust</h3>
                                <p>70% of first impressions are formed on mobile. Consistent UI boosts sign-up confidence.</p>
                            </article>
                            <article class="insight reveal" style="--delay: 0.3s;">
                                <h3>Regional storytelling</h3>
                                <p>Brands that connect to local community narratives see higher referrals in the first quarter.</p>
                            </article>
                        </div>
                    </div>
                </section>

                <section class="section testimonials">
                    <div class="container">
                        <div class="section-head">
                            <div>
                                <p class="eyebrow reveal" style="--delay: 0.1s;">Client voices</p>
                                <h2 class="section-title reveal" style="--delay: 0.2s;">Teams stay with us for the partnership, not just the deliverables.</h2>
                            </div>
                            <p class="section-lead reveal" style="--delay: 0.3s;">We work closely with marketing leads, founders, and product teams to make rollouts smooth.</p>
                        </div>
                        <div class="testimonial-grid">
                            <blockquote class="testimonial reveal" style="--delay: 0.1s;">
                                <p>"Aurix gave us a brand language that fits Nairobi and still feels global. The launch kit saved weeks of internal work."</p>
                                <cite>Amara K., Marketing Lead, Orbit Health</cite>
                            </blockquote>
                            <blockquote class="testimonial reveal" style="--delay: 0.2s;">
                                <p>"The strategy sprint pushed our team to focus on what makes us different. We saw immediate uptick in inbound leads."</p>
                                <cite>David O., Founder, Lakeview Labs</cite>
                            </blockquote>
                        </div>
                    </div>
                </section>

                <section id="contact" class="section contact">
                    <div class="container contact-grid">
                        <div>
                            <p class="eyebrow reveal" style="--delay: 0.1s;">Start a project</p>
                            <h2 class="section-title reveal" style="--delay: 0.2s;">Tell us what you are building.</h2>
                            <p class="section-lead reveal" style="--delay: 0.3s;">We respond within two business days with a scope outline and next steps.</p>
                            <div class="contact-details reveal" style="--delay: 0.4s;">
                                <p>hello@aurix.co.ke</p>
                                <p>Nairobi - Westlands</p>
                            </div>
                        </div>
                        <form class="contact-form reveal" style="--delay: 0.2s;">
                            <label>
                                Name
                                <input type="text" name="name" placeholder="Your name">
                            </label>
                            <label>
                                Email
                                <input type="email" name="email" placeholder="you@company.co.ke">
                            </label>
                            <label>
                                Project summary
                                <textarea name="project" rows="4" placeholder="What do you need help with?"></textarea>
                            </label>
                            <button type="submit" class="btn">Request a proposal</button>
                            <p class="form-note">By submitting, you agree to a short discovery call.</p>
                        </form>
                    </div>
                </section>
            </main>

            <footer class="site-footer">
                <div class="container footer-grid">
                    <div>
                        <a class="brand" href="#top">
                            <img class="brand-mark" src="/images/aurix-mark.svg" alt="" width="28" height="28" aria-hidden="true">
                            <span class="brand-name">Aurix</span>
                        </a>
                        <p>Brand systems built for Kenyan growth teams and founders.</p>
                    </div>
                    <div>
                        <h4>Studios</h4>
                        <p>Nairobi, Kenya</p>
                        <p>Remote across East Africa</p>
                    </div>
                    <div>
                        <h4>Contact</h4>
                        <p>hello@aurix.co.ke</p>
                        <p>+254 700 000 000</p>
                    </div>
                </div>
                <div class="footer-bottom">
                    <p>2026 Aurix Brand Studio. All rights reserved.</p>
                </div>
            </footer>
        </div>
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </body>
</html>
