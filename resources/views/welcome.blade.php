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
    </head>
    <body>
        <div class="page">
            <header class="site-header">
                <div class="container nav">
                    <a class="brand" href="#top" aria-label="Aurix home">
                        <span class="brand-mark"></span>
                        Aurix
                    </a>
                    <nav class="nav-links" aria-label="Primary">
                        <a href="#work">Work</a>
                        <a href="#services">Services</a>
                        <a href="#process">Process</a>
                        <a href="#insights">Insights</a>
                    </nav>
                    <div class="nav-actions">
                        <a class="btn btn-secondary" href="#contact">Start a project</a>
                    </div>
                </div>
            </header>

            <main id="top">
                <section class="hero">
                    <div class="container hero-grid">
                        <div class="hero-copy">
                            <p class="hero-kicker reveal" style="--delay: 0.05s;">Next Generation</p>
                            <h1 class="hero-title reveal" style="--delay: 0.15s;">Aurix</h1>
                            <p class="hero-subtitle reveal" style="--delay: 0.22s;">Multipurpose brand studio for East Africa</p>
                            <p class="hero-lead reveal" style="--delay: 0.3s;">From Nairobi startups to Mombasa hospitality groups, we build brand systems that move fast and stay consistent across every touchpoint.</p>
                            <div class="hero-actions reveal" style="--delay: 0.35s;">
                                <a class="btn" href="#contact">Book a brand sprint</a>
                                <a class="btn btn-ghost" href="#work">View recent work</a>
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
                            <div class="hero-card">
                                <div class="card-title">Aurix Brand Sprint</div>
                                <p>Strategy, identity, and rollout aligned in 10 focused working days.</p>
                                <ul>
                                    <li>Positioning workshop</li>
                                    <li>Visual system + logo suite</li>
                                    <li>Launch toolkit</li>
                                </ul>
                            </div>
                            <div class="hero-panel">
                                <div class="panel-label">Featured client</div>
                                <div class="panel-title">Lengo Logistics</div>
                                <p>Rebrand for a 30-truck fleet expanding between Nairobi and Eldoret.</p>
                                <div class="panel-metrics">
                                    <span>+42% recall</span>
                                    <span>3 new depots</span>
                                </div>
                            </div>
                            <div class="hero-badge">KSh-friendly retainers</div>
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
                                <h2 class="section-title reveal" style="--delay: 0.2s;">Everything you need to launch, scale, and stay consistent.</h2>
                            </div>
                            <p class="section-lead reveal" style="--delay: 0.3s;">We partner with founders who want clarity and energy in their story. Every engagement includes clear timelines, local market insight, and sharp execution.</p>
                        </div>
                        <div class="cards-grid">
                            <article class="card reveal" style="--delay: 0.1s;">
                                <h3>Brand strategy</h3>
                                <p>Positioning, messaging, and differentiation tuned for Kenyan audiences.</p>
                            </article>
                            <article class="card reveal" style="--delay: 0.2s;">
                                <h3>Visual identity</h3>
                                <p>Logo systems, typography, and colors that translate from billboards to apps.</p>
                            </article>
                            <article class="card reveal" style="--delay: 0.3s;">
                                <h3>Packaging + retail</h3>
                                <p>Packaging, wayfinding, and in-store brand cues that drive shelf presence.</p>
                            </article>
                            <article class="card reveal" style="--delay: 0.4s;">
                                <h3>Digital experiences</h3>
                                <p>Web and product design for experiences that feel seamless on mobile.</p>
                            </article>
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
                                <h3>Kifaru Outdoor Gear</h3>
                                <p>Unified brand system for new stores and ecommerce rollout.</p>
                                <div class="case-metrics">
                                    <span>+38% repeat buyers</span>
                                    <span>12 store kits</span>
                                </div>
                            </article>
                            <article class="case-card reveal" style="--delay: 0.2s;">
                                <div class="case-meta">Fintech / Kisumu</div>
                                <h3>PesaLink Partners</h3>
                                <p>Brand refresh and app UI for a youth-first wallet.</p>
                                <div class="case-metrics">
                                    <span>2x sign-ups</span>
                                    <span>45k new users</span>
                                </div>
                            </article>
                            <article class="case-card reveal" style="--delay: 0.3s;">
                                <div class="case-meta">Hospitality / Mombasa</div>
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
                            <span class="brand-mark"></span>
                            Aurix
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
    </body>
</html>
