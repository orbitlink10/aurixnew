<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Embroidery Quote | Aurix Branding</title>
    <meta name="description" content="Request an Aurix Branding embroidery quote for uniforms, polos, hoodies, caps, and corporate apparel.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/aurix-branding-logo.png') }}" type="image/png">
    <style>
        :root { --gold: #c9942f; --gold-light: #f1cf7a; --black: #050505; --ink: #17140f; --muted: #6f675b; --line: rgba(23, 20, 15, 0.13); --soft: #f7f3ea; --ivory: #fffaf1; }
        * { box-sizing: border-box; }
        html, body { max-width: 100%; overflow-x: hidden; }
        body { margin: 0; background: var(--soft); color: var(--ink); font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 15px; }
        a { color: inherit; text-decoration: none; }
        button, input, textarea { font: inherit; }
        .wrap { width: min(1530px, calc(100% - 56px)); margin: 0 auto; }
        .header { position: sticky; top: 0; z-index: 30; background: rgba(255, 250, 241, 0.96); border-bottom: 1px solid var(--line); backdrop-filter: blur(14px); }
        .nav { display: grid; min-height: 92px; grid-template-columns: 240px minmax(0, 1fr) auto; align-items: center; gap: 22px; }
        .brand { display: inline-flex; min-width: 0; align-items: center; gap: 12px; color: var(--ink); font-size: 18px; font-weight: 900; white-space: nowrap; }
        .brand img { width: 54px; height: 54px; flex: 0 0 54px; border-radius: 2px; object-fit: cover; }
        .nav-links { display: flex; min-width: 0; justify-content: center; gap: clamp(12px, 1.15vw, 22px); overflow-x: auto; scrollbar-width: none; font-size: 14px; font-weight: 700; white-space: nowrap; }
        .nav-links::-webkit-scrollbar { display: none; }
        .nav-links a.is-active { color: var(--gold); }
        .phone-link { display: inline-flex; min-height: 46px; align-items: center; border: 1px solid var(--line); border-radius: 999px; background: #fffaf1; padding: 0 18px; font-weight: 900; white-space: nowrap; }
        .page { padding: 58px 0 70px; }
        .contact-hero { border-radius: 34px; background: radial-gradient(circle at 80% 20%, rgba(241, 207, 122, 0.16), transparent 34%), linear-gradient(120deg, #050505, #17140f 58%, #2b2518); color: #fffaf1; padding: clamp(30px, 4vw, 48px); box-shadow: 0 28px 70px rgba(23, 20, 15, 0.18); }
        .pill { display: block; max-width: 100%; border-radius: 999px; background: rgba(255, 250, 241, 0.14); padding: 8px 22px; color: #fffaf1; font-size: 14px; font-weight: 900; letter-spacing: .34em; text-transform: uppercase; }
        .contact-hero h1 { margin: 42px 0 22px; font-size: clamp(3rem, 5vw, 5.4rem); line-height: 1.05; font-weight: 500; }
        .contact-hero p { max-width: 1040px; margin: 0; color: rgba(255, 250, 241, 0.84); font-size: 19px; line-height: 1.65; }
        .contact-chips { display: flex; flex-wrap: wrap; gap: 16px; margin-top: 40px; }
        .contact-chips a, .contact-chips span { display: inline-flex; min-height: 62px; align-items: center; justify-content: center; border: 1px solid rgba(255, 250, 241, 0.28); border-radius: 999px; padding: 0 30px; color: #fffaf1; font-size: 17px; font-weight: 900; }
        .contact-form-card { margin: 34px auto 0; border: 1px solid var(--line); border-radius: 28px; background: #fffaf1; padding: clamp(26px, 3vw, 44px); box-shadow: 0 18px 48px rgba(23, 20, 15, .08); }
        .contact-form { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; }
        .field { display: grid; gap: 12px; color: #050505; font-size: 17px; font-weight: 700; }
        .field.full { grid-column: 1 / -1; }
        .field input, .field textarea { width: 100%; border: 1px solid rgba(23, 20, 15, 0.16); border-radius: 16px; background: #ffffff; color: var(--ink); padding: 16px 18px; font-size: 16px; outline: 0; transition: border-color .18s ease, box-shadow .18s ease; }
        .field textarea { min-height: 220px; resize: vertical; }
        .field input:focus, .field textarea:focus { border-color: var(--gold); box-shadow: 0 0 0 4px rgba(201, 148, 47, 0.16); }
        .send-btn { width: fit-content; min-height: 60px; border: 0; border-radius: 999px; background: linear-gradient(135deg, var(--gold), var(--gold-light)); color: var(--black); padding: 0 34px; font-size: 17px; font-weight: 900; cursor: pointer; }
        .form-alert { grid-column: 1 / -1; border-radius: 16px; padding: 16px 18px; font-size: 15px; font-weight: 800; }
        .form-alert.success { border: 1px solid rgba(22, 101, 52, .18); background: #ecfdf5; color: #166534; }
        .form-alert.error { border: 1px solid rgba(185, 28, 28, .18); background: #fef2f2; color: #991b1b; }
        .field-error { color: #991b1b; font-size: 13px; font-weight: 800; }
        .footer { background: #111111; color: #fffaf1; padding: 34px 0; }
        .footer .wrap { display: flex; flex-wrap: wrap; justify-content: space-between; gap: 18px; }
        .footer p, .footer a { margin: 0; color: rgba(255, 250, 241, 0.72); line-height: 1.65; }
        @media (max-width: 1180px) { .nav { grid-template-columns: 1fr; padding: 18px 0; } .nav-links { justify-content: flex-start; } .phone-link { width: fit-content; } }
        @media (max-width: 760px) { .wrap { width: min(100% - 28px, 1530px); } .contact-form { grid-template-columns: 1fr; } .field.full { grid-column: auto; } .contact-hero h1 { font-size: 2.65rem; } .contact-hero { border-radius: 26px; padding: 28px; } }
    </style>
</head>
<body>
    @php
        $displayPhone = '+254 700816670';
        $contactEmail = 'info@aurixbranding.co.ke';
    @endphp

    <header class="header">
        <div class="wrap nav">
            <a href="{{ url('/') }}" class="brand" aria-label="Aurix Branding home">
                <img src="{{ $logoUrl ?: asset('images/aurix-branding-logo.png') }}" alt="Aurix Branding logo">
                <span>Aurix Branding</span>
            </a>
            <nav class="nav-links" aria-label="Main navigation">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ route('public.products.index') }}">Shop</a>
                <a href="{{ route('public.products.index', ['category' => 'corporate']) }}">Corporate</a>
                <a href="{{ route('public.embroidery') }}" class="is-active">Embroidery</a>
                <a href="{{ route('public.create-design') }}">Create Design</a>
            </nav>
            <a class="phone-link" href="tel:+254700816670">{{ $displayPhone }}</a>
        </div>
    </header>

    <main class="page">
        <section class="wrap">
            <div class="contact-hero">
                <span class="pill">Contact</span>
                <h1>Talk to Aurix Branding</h1>
                <p>Send us your embroidery question, order details, or branding request. Once you click send, your message will be emailed directly to Aurix Branding.</p>
                <div class="contact-chips">
                    <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>
                    <a href="tel:+254700816670">{{ $displayPhone }}</a>
                </div>
            </div>

            <div class="contact-form-card">
                <form class="contact-form" id="embroideryQuoteForm" action="{{ route('public.embroidery.quote.send') }}" method="POST">
                    @csrf
                    @if(session('quote_success'))
                        <div class="form-alert success">{{ session('quote_success') }}</div>
                    @endif
                    @if(session('quote_error'))
                        <div class="form-alert error">{{ session('quote_error') }}</div>
                    @endif
                    <label class="field">
                        Full name
                        <input type="text" name="name" value="{{ old('name') }}" autocomplete="name" required>
                        @error('name')<span class="field-error">{{ $message }}</span>@enderror
                    </label>
                    <label class="field">
                        Email
                        <input type="email" name="email" value="{{ old('email') }}" autocomplete="email">
                        @error('email')<span class="field-error">{{ $message }}</span>@enderror
                    </label>
                    <label class="field">
                        Phone (optional)
                        <input type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel">
                        @error('phone')<span class="field-error">{{ $message }}</span>@enderror
                    </label>
                    <label class="field">
                        Subject
                        <input type="text" name="subject" value="{{ old('subject', 'Embroidery quote request') }}">
                        @error('subject')<span class="field-error">{{ $message }}</span>@enderror
                    </label>
                    <label class="field full">
                        Message
                        <textarea name="message" required placeholder="Tell us what you need embroidered, quantity, garment type, timeline, and logo placement.">{{ old('message') }}</textarea>
                        @error('message')<span class="field-error">{{ $message }}</span>@enderror
                    </label>
                    <button class="send-btn" type="submit">Send message</button>
                </form>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="wrap">
            <p>© {{ date('Y') }} Aurix Branding. All rights reserved.</p>
            <a href="{{ route('public.embroidery') }}">Back to embroidery</a>
        </div>
    </footer>
</body>
</html>
