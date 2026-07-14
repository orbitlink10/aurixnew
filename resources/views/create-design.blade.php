<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Design | Aurix Branding</title>
    <meta name="description" content="Design custom Aurix Branding apparel and products online. Choose products, colors, front or back view, add text, and upload artwork.">
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
            --accent: #2f7cf6;
        }
        * { box-sizing: border-box; }
        html, body { height: 100%; max-width: 100%; overflow: hidden; }
        body { margin: 0; background: #ece8df; color: var(--ink); font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 13px; }
        button, input, select, textarea { font: inherit; }
        button { cursor: pointer; }
        a { color: inherit; text-decoration: none; }
        .studio { display: grid; height: 100dvh; grid-template-rows: 76px minmax(0, 1fr) 52px; }
        .topbar { display: grid; grid-template-columns: auto minmax(0, 1fr) auto; align-items: center; gap: 18px; background: linear-gradient(90deg, #050505, #17140f 45%, #2b2518); color: #fffaf1; padding: 0 22px; }
        .brand { display: inline-flex; align-items: center; gap: 10px; font-size: 17px; font-weight: 900; white-space: nowrap; }
        .brand img { width: 42px; height: 42px; border-radius: 2px; object-fit: cover; }
        .top-menu { display: flex; min-width: 0; align-items: center; justify-content: center; gap: clamp(10px, 1.6vw, 24px); overflow-x: auto; scrollbar-width: none; font-size: 14px; font-weight: 800; }
        .top-menu::-webkit-scrollbar { display: none; }
        .top-actions { display: flex; align-items: center; gap: 12px; }
        .tool-btn, .primary-btn, .ghost-btn { min-height: 40px; border-radius: 999px; font-size: 13px; font-weight: 900; }
        .tool-btn { min-width: 40px; border: 1px solid rgba(255, 250, 241, 0.28); background: rgba(255, 250, 241, 0.1); color: #fffaf1; }
        .primary-btn { border: 0; background: linear-gradient(135deg, var(--gold), var(--gold-light)); color: var(--black); padding: 0 18px; }
        .ghost-btn { border: 1px solid rgba(255, 250, 241, 0.28); background: rgba(255, 250, 241, 0.1); color: #fffaf1; padding: 0 16px; }
        .share-btn { border: 0; background: #fffaf1; color: var(--black); padding: 0 18px; }
        .workspace { display: grid; min-height: 0; grid-template-columns: 92px 370px minmax(0, 1fr); }
        .rail { display: grid; align-content: start; gap: 15px; border-right: 1px solid #d8d1c3; background: #fffaf1; padding: 28px 8px; text-align: center; }
        .rail button { display: grid; gap: 6px; justify-items: center; border: 0; background: transparent; color: #111; font-weight: 800; }
        .rail button.is-active { color: var(--gold); }
        .rail span { display: grid; width: 30px; height: 30px; place-items: center; border-radius: 10px; font-size: 16px; }
        .rail button.is-active span { background: rgba(201, 148, 47, 0.14); }
        .sidebar { min-height: 0; overflow-y: auto; border-right: 1px solid #d8d1c3; background: #fffaf1; padding: 24px 22px; }
        .tabs { display: flex; gap: 22px; border-bottom: 1px solid #ded7ca; margin-bottom: 24px; }
        .tabs button { border: 0; border-bottom: 2px solid transparent; background: transparent; padding: 0 0 14px; font-size: 15px; font-weight: 800; }
        .tabs button.is-active { border-color: var(--gold); color: var(--gold); }
        .panel-title { margin: 0 0 15px; font-size: 19px; }
        .product-strip { display: block; }
        .products { display: flex; gap: 14px; overflow-x: auto; padding-bottom: 10px; scroll-snap-type: x mandatory; }
        .product-card { min-width: 166px; scroll-snap-align: start; border: 1px solid #d8d1c3; border-radius: 16px; background: #ffffff; padding: 12px; text-align: left; }
        .product-card.is-active { border-color: var(--gold); background: rgba(201, 148, 47, 0.08); box-shadow: inset 0 0 0 1px var(--gold); }
        .product-icon { display: grid; width: 76px; height: 58px; place-items: center; overflow: hidden; border-radius: 14px; background: #fffaf1; }
        .product-icon img { width: 100%; height: 100%; object-fit: cover; }
        .product-card strong { display: block; margin-top: 10px; font-size: 14px; }
        .section { margin-top: 24px; }
        .swatches { display: grid; grid-template-columns: repeat(7, 34px); gap: 12px; }
        .swatch { width: 34px; height: 34px; border: 2px solid #e5dece; border-radius: 999px; box-shadow: inset 0 0 0 2px #fff; }
        .swatch.is-active { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201, 148, 47, 0.18), inset 0 0 0 2px #fff; }
        .segmented { display: flex; flex-wrap: wrap; gap: 10px; }
        .segmented button, .pill-btn { min-height: 38px; border: 1px solid #d8d1c3; border-radius: 999px; background: #fff; padding: 0 15px; font-size: 13px; font-weight: 800; }
        .segmented button.is-active { border-color: var(--gold); background: linear-gradient(135deg, var(--gold), var(--gold-light)); color: var(--black); }
        .upload-box { border: 1px dashed rgba(201, 148, 47, 0.55); border-radius: 18px; background: rgba(201, 148, 47, 0.08); padding: 18px; }
        .upload-box input { width: 100%; }
        .text-row { display: grid; grid-template-columns: 1fr auto; gap: 10px; }
        .text-row input, .font-select { min-height: 38px; border: 1px solid #d8d1c3; border-radius: 12px; background: #fff; padding: 0 12px; font-size: 13px; }
        .range { width: 100%; accent-color: var(--gold); }
        .stage-wrap { display: grid; min-width: 0; min-height: 0; grid-template-rows: auto minmax(0, 1fr); background: linear-gradient(180deg, #f6ece8, #f4ede4); }
        .stage-toolbar { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 16px 22px; }
        .mode-tabs { display: inline-flex; overflow: hidden; border: 1px solid #d8d1c3; border-radius: 16px; background: #fff; padding: 8px; }
        .mode-tabs button { border: 0; border-radius: 12px; background: transparent; padding: 10px 18px; font-size: 14px; font-weight: 800; }
        .mode-tabs button.is-active { background: rgba(201, 148, 47, 0.12); color: var(--gold); }
        .stage-actions { display: flex; gap: 10px; }
        .stage-action { display: grid; width: 40px; height: 40px; place-items: center; border: 1px solid #d8d1c3; border-radius: 14px; background: #fffaf1; font-size: 16px; }
        .canvas-area { position: relative; min-height: 0; overflow: auto; padding: 18px 84px 38px; }
        .canvas { position: relative; display: grid; width: min(760px, 100%); min-height: 720px; place-items: center; margin: 0 auto; border: 1px solid #ded7ca; background: #fff; box-shadow: 0 28px 70px rgba(23, 20, 15, 0.12); }
        .mockup { --product-mask-image: none; position: relative; display: grid; width: min(540px, 76%); aspect-ratio: 1 / 1; place-items: center; filter: drop-shadow(0 22px 28px rgba(0,0,0,.13)); }
        .mockup-image { position: absolute; inset: 0; display: block; width: 100%; height: 100%; object-fit: contain; z-index: 3; pointer-events: none; }
        .mockup:not([data-color-mode="white"]) .mockup-image { mix-blend-mode: multiply; opacity: .34; filter: grayscale(1) contrast(.86) brightness(1.32); }
        .color-tint { position: absolute; inset: 0; display: block; background: var(--product-color, #ffffff); mask-image: var(--product-mask-image); mask-size: contain; mask-position: center; mask-repeat: no-repeat; -webkit-mask-image: var(--product-mask-image); -webkit-mask-size: contain; -webkit-mask-position: center; -webkit-mask-repeat: no-repeat; opacity: 1; z-index: 2; pointer-events: none; transition: background-color .12s ease; }
        .mockup[data-color-mode="white"] .color-tint { opacity: 0; }
        .product-vector { display: none; }
        .product-group { display: none; }
        .mockup.tshirt .product-tshirt,
        .mockup.hoodie .product-hoodie,
        .mockup.cap .product-cap,
        .mockup.mug .product-mug,
        .mockup.polo .product-polo,
        .mockup.sweater .product-sweater,
        .mockup.kids .product-kids { display: block; }
        .product-fill { fill: var(--product-color, #ffffff); transition: fill .12s ease; filter: url(#fabricTexture); }
        .product-panel { fill: url(#softShade); opacity: .22; mix-blend-mode: multiply; }
        .product-highlight { fill: url(#softHighlight); opacity: .55; mix-blend-mode: screen; }
        .product-stitch { fill: none; stroke: rgba(17, 17, 17, .16); stroke-width: 3; stroke-linecap: round; stroke-dasharray: 8 8; opacity: .45; }
        .product-edge { fill: none; stroke: rgba(17, 17, 17, .18); stroke-width: 3.5; stroke-linejoin: round; }
        .product-shadow { fill: rgba(0, 0, 0, .12); filter: blur(9px); }
        .print-area { position: absolute; left: var(--print-left, 22%); top: var(--print-top, 26%); width: var(--print-width, 56%); height: var(--print-height, 36%); border: 2px dashed rgba(47, 124, 246, 0.5); outline: 2px solid rgba(47, 124, 246, 0.18); outline-offset: 8px; z-index: 4; isolation: isolate; }
        .design-layer { position: absolute; left: 50%; top: 50%; max-width: 84%; max-height: 84%; transform: translate(-50%, -50%); z-index: 5; cursor: move; user-select: none; mix-blend-mode: normal; }
        .design-text { min-width: 120px; color: #111; font-size: 34px; font-weight: 900; text-align: center; }
        .design-image { width: 180px; height: auto; }
        .mockup:not([data-color-mode="white"]) .design-layer { filter: drop-shadow(0 1px 1px rgba(255, 255, 255, .75)) drop-shadow(0 2px 5px rgba(0, 0, 0, .24)); }
        .mockup[data-color-mode="deep"] .design-text { color: #fff; text-shadow: 0 1px 1px rgba(0, 0, 0, .55), 0 0 5px rgba(255, 255, 255, .2); }
        .mockup[data-color-mode="deep"] .design-image { filter: drop-shadow(0 0 1px rgba(255, 255, 255, .95)) drop-shadow(0 2px 7px rgba(255, 255, 255, .46)); }
        .selected-box { position: absolute; left: 20%; top: 24%; width: 60%; height: 40%; border: 2px solid var(--accent); pointer-events: none; z-index: 8; }
        .selected-box::before, .selected-box::after { content: ""; position: absolute; width: 14px; height: 14px; border-radius: 999px; background: var(--accent); }
        .selected-box::before { left: 50%; top: -8px; transform: translateX(-50%); }
        .selected-box::after { right: -8px; bottom: -8px; }
        .flip-panel { position: absolute; right: 26px; top: 50%; transform: translateY(-50%); display: grid; gap: 12px; border: 1px solid #d8d1c3; border-radius: 24px; background: #fffaf1; padding: 12px; box-shadow: 0 18px 42px rgba(23, 20, 15, .08); text-align: center; color: #667085; font-weight: 900; letter-spacing: .2em; }
        .flip-panel button { display: grid; width: 46px; height: 46px; place-items: center; border: 1px solid #d8d1c3; border-radius: 999px; background: #fff; color: var(--ink); font-size: 20px; }
        .bottombar { display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #d8d1c3; background: #fffaf1; padding: 0 26px; color: var(--muted); font-size: 17px; }
        .zoom { display: flex; align-items: center; gap: 14px; font-weight: 900; }
        .zoom input { accent-color: var(--gold); }
        @media (max-width: 1180px) {
            html, body { overflow: auto; height: auto; }
            .studio { height: auto; min-height: 100dvh; grid-template-rows: auto auto auto; }
            .topbar { grid-template-columns: 1fr; padding: 16px; }
            .top-menu, .top-actions { justify-content: flex-start; overflow-x: auto; }
            .workspace { grid-template-columns: 84px minmax(280px, 360px) minmax(680px, 1fr); overflow-x: auto; }
        }
    </style>
</head>
<body>
    @php
        $products = [
            ['key' => 'tshirt', 'label' => 'Tshirt', 'front_image' => asset('images/studio-tshirt-front.png'), 'back_image' => asset('images/studio-tshirt-back.png'), 'front_mask' => asset('images/studio-tshirt-front.png'), 'back_mask' => asset('images/studio-tshirt-back.png'), 'front_print' => ['left' => '31%', 'top' => '31%', 'width' => '38%', 'height' => '31%'], 'back_print' => ['left' => '31%', 'top' => '28%', 'width' => '38%', 'height' => '35%'], 'light' => 'light'],
            ['key' => 'hoodie', 'label' => 'Hoodie', 'front_image' => asset('images/studio-hoodie-front.png'), 'back_image' => asset('images/studio-hoodie-back.png'), 'front_mask' => asset('images/studio-hoodie-front.png'), 'back_mask' => asset('images/studio-hoodie-back.png'), 'front_print' => ['left' => '32%', 'top' => '34%', 'width' => '36%', 'height' => '25%'], 'back_print' => ['left' => '31%', 'top' => '33%', 'width' => '38%', 'height' => '32%'], 'light' => 'dark'],
            ['key' => 'cap', 'label' => 'Cap', 'front_image' => asset('images/studio-cap-front.png'), 'back_image' => asset('images/studio-cap-back.png'), 'front_mask' => asset('images/studio-cap-front.png'), 'back_mask' => asset('images/studio-cap-back.png'), 'front_print' => ['left' => '34%', 'top' => '35%', 'width' => '32%', 'height' => '18%'], 'back_print' => ['left' => '35%', 'top' => '34%', 'width' => '30%', 'height' => '16%'], 'light' => 'dark'],
            ['key' => 'mug', 'label' => 'Mug', 'front_image' => asset('images/studio-mug-front.png'), 'back_image' => asset('images/studio-mug-back.png'), 'front_mask' => asset('images/studio-mug-front.png'), 'back_mask' => asset('images/studio-mug-back.png'), 'front_print' => ['left' => '42%', 'top' => '28%', 'width' => '34%', 'height' => '43%'], 'back_print' => ['left' => '24%', 'top' => '28%', 'width' => '34%', 'height' => '43%'], 'light' => 'light'],
            ['key' => 'polo', 'label' => 'Polo shirt', 'front_image' => asset('images/studio-polo-front.png'), 'back_image' => asset('images/studio-polo-back.png'), 'front_mask' => asset('images/studio-polo-front.png'), 'back_mask' => asset('images/studio-polo-back.png'), 'front_print' => ['left' => '33%', 'top' => '32%', 'width' => '34%', 'height' => '29%'], 'back_print' => ['left' => '31%', 'top' => '27%', 'width' => '38%', 'height' => '35%'], 'light' => 'dark'],
            ['key' => 'sweater', 'label' => 'Sweatshirt', 'front_image' => asset('images/studio-sweatshirt-front.png'), 'back_image' => asset('images/studio-sweatshirt-back.png'), 'front_mask' => asset('images/studio-sweatshirt-front.png'), 'back_mask' => asset('images/studio-sweatshirt-back.png'), 'front_print' => ['left' => '30%', 'top' => '30%', 'width' => '40%', 'height' => '33%'], 'back_print' => ['left' => '30%', 'top' => '28%', 'width' => '40%', 'height' => '36%'], 'light' => 'light'],
            ['key' => 'totebag', 'label' => 'Tote bag', 'front_image' => asset('images/studio-totebag-front.png'), 'back_image' => asset('images/studio-totebag-back.png'), 'front_mask' => asset('images/studio-totebag-front.png'), 'back_mask' => asset('images/studio-totebag-back.png'), 'front_print' => ['left' => '27%', 'top' => '42%', 'width' => '46%', 'height' => '32%'], 'back_print' => ['left' => '27%', 'top' => '42%', 'width' => '46%', 'height' => '32%'], 'light' => 'light'],
            ['key' => 'kids', 'label' => 'Kids clothes', 'front_image' => asset('images/studio-kids-front.png'), 'back_image' => asset('images/studio-kids-back.png'), 'front_mask' => asset('images/studio-kids-front.png'), 'back_mask' => asset('images/studio-kids-back.png'), 'front_print' => ['left' => '34%', 'top' => '30%', 'width' => '32%', 'height' => '34%'], 'back_print' => ['left' => '34%', 'top' => '29%', 'width' => '32%', 'height' => '36%'], 'light' => 'light'],
        ];
    @endphp

    <div class="studio">
        <header class="topbar">
            <a href="{{ url('/') }}" class="brand">
                <img src="{{ $logoUrl ?: asset('images/aurix-branding-logo.png') }}" alt="Aurix Branding logo">
                <span>Aurix Studio</span>
            </a>
            <nav class="top-menu" aria-label="Studio tools">
                <a href="{{ route('public.products.index') }}">File</a>
                <button type="button" data-fit>Resize</button>
                <button type="button" data-focus-text>Editing</button>
                <button class="tool-btn" type="button" data-undo>←</button>
                <button class="tool-btn" type="button" data-redo>→</button>
                <strong>Free Version.Ke</strong>
            </nav>
            <div class="top-actions">
                <button class="ghost-btn" type="button" data-save>Save design</button>
                <button class="ghost-btn" type="button" data-add-cart>Add to cart</button>
                <a class="ghost-btn" href="{{ route('public.products.index') }}">Back to shop</a>
                <button class="primary-btn share-btn" type="button" data-share>Share</button>
            </div>
        </header>

        <main class="workspace">
            <aside class="rail" aria-label="Studio sections">
                <button class="is-active" type="button"><span>◒</span>Products</button>
                <button type="button"><span>▦</span>Templates</button>
                <button type="button"><span>▣</span>Apps</button>
                <button type="button" data-upload-shortcut><span>▤</span>Uploads</button>
                <button type="button" data-focus-text><span>✎</span>Edit</button>
                <button type="button"><span>▦</span>QR Code</button>
            </aside>

            <aside class="sidebar">
                <div class="tabs">
                    <button class="is-active" type="button">All</button>
                    <button type="button">Designs</button>
                    <button type="button">Folders</button>
                </div>

                <h2 class="panel-title">Product Mockups</h2>
                <div class="product-strip">
                    <div class="products" id="productList">
                        @foreach($products as $product)
                            <button class="product-card {{ $loop->first ? 'is-active' : '' }}" type="button" data-product="{{ $product['key'] }}" data-label="{{ $product['label'] }}" data-front-image="{{ $product['front_image'] }}" data-back-image="{{ $product['back_image'] }}" data-front-mask="{{ $product['front_mask'] }}" data-back-mask="{{ $product['back_mask'] }}" data-light="{{ $product['light'] }}" data-front-print-left="{{ $product['front_print']['left'] }}" data-front-print-top="{{ $product['front_print']['top'] }}" data-front-print-width="{{ $product['front_print']['width'] }}" data-front-print-height="{{ $product['front_print']['height'] }}" data-back-print-left="{{ $product['back_print']['left'] }}" data-back-print-top="{{ $product['back_print']['top'] }}" data-back-print-width="{{ $product['back_print']['width'] }}" data-back-print-height="{{ $product['back_print']['height'] }}">
                                <span class="product-icon"><img src="{{ $product['front_image'] }}" alt="{{ $product['label'] }} mockup"></span>
                                <strong>{{ $product['label'] }}</strong>
                            </button>
                        @endforeach
                    </div>
                </div>

                <section class="section">
                    <h2 class="panel-title">Colors</h2>
                    <div class="swatches" id="swatches">
                        @foreach(['#ffffff','#111111','#c9942f','#f1cf7a','#ef4444','#f59e0b','#2563eb','#15803d','#581c87','#ec4899','#e5e7eb','#94a3b8','#0f172a','#fde68a'] as $color)
                            <button class="swatch {{ $loop->first ? 'is-active' : '' }}" type="button" style="background: {{ $color }}" data-color="{{ $color }}" aria-label="Choose {{ $color }}"></button>
                        @endforeach
                    </div>
                </section>

                <section class="section">
                    <h2 class="panel-title">Views</h2>
                    <div class="segmented">
                        <button class="is-active" type="button" data-view="front">Front</button>
                        <button type="button" data-view="back">Back</button>
                    </div>
                </section>

                <section class="section">
                    <h2 class="panel-title">Upload Design</h2>
                    <div class="upload-box">
                        <input id="uploadInput" type="file" accept="image/*">
                    </div>
                </section>

                <section class="section">
                    <h2 class="panel-title">Text Tools</h2>
                    <div class="text-row">
                        <input id="textInput" type="text" value="Aurix" aria-label="Design text">
                        <button class="pill-btn" type="button" data-add-text>Add</button>
                    </div>
                    <div class="section">
                        <select class="font-select" id="fontSelect" aria-label="Font family">
                            <option value="Inter">Inter</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Arial Black">Arial Black</option>
                            <option value="Trebuchet MS">Trebuchet</option>
                        </select>
                    </div>
                </section>

                <section class="section">
                    <h2 class="panel-title">Alignment</h2>
                    <div class="segmented">
                        <button type="button" data-center-x>Center X</button>
                        <button type="button" data-center-y>Center Y</button>
                    </div>
                </section>

                <section class="section">
                    <h2 class="panel-title">Layers & Style</h2>
                    <div class="segmented">
                        <button type="button" data-layer="front">Bring Forward</button>
                        <button type="button" data-layer="back">Send Back</button>
                        <button type="button" data-flip-h>Flip H</button>
                        <button type="button" data-flip-v>Flip V</button>
                        <button type="button" data-delete>Delete</button>
                    </div>
                    <p>Opacity</p>
                    <input class="range" id="opacityRange" type="range" min="10" max="100" value="100">
                    <p>Size</p>
                    <input class="range" id="sizeRange" type="range" min="40" max="300" value="180">
                </section>
            </aside>

            <section class="stage-wrap">
                <div class="stage-toolbar">
                    <div class="mode-tabs">
                        <button class="is-active" type="button">Text Tools</button>
                        <button type="button">Remove Background</button>
                    </div>
                    <div class="stage-actions">
                        <button class="stage-action" type="button" data-lock>♙</button>
                        <button class="stage-action" type="button" data-duplicate>⧉</button>
                        <button class="stage-action" type="button" data-delete>🗑</button>
                        <button class="stage-action" type="button" data-add-text>＋</button>
                    </div>
                </div>

                <div class="canvas-area" id="canvasArea">
                    <div class="canvas" id="canvas">
                        <div class="mockup tshirt" id="mockup" data-light="light" data-color-mode="white" style="--product-color: #ffffff; --product-mask-image: url('{{ asset('images/studio-tshirt-front.png') }}'); --print-left: 31%; --print-top: 31%; --print-width: 38%; --print-height: 31%;">
                            <img class="mockup-image" id="mockupImage" src="{{ asset('images/studio-tshirt-front.png') }}" alt="Selected product mockup">
                            <span class="color-tint"></span>
                            <svg class="product-vector" viewBox="0 0 600 600" role="img" aria-label="Selected product template">
                                <defs>
                                    <filter id="fabricTexture" x="-20%" y="-20%" width="140%" height="140%">
                                        <feTurbulence type="fractalNoise" baseFrequency="0.9" numOctaves="2" seed="7" result="noise"></feTurbulence>
                                        <feColorMatrix in="noise" type="saturate" values="0"></feColorMatrix>
                                        <feComponentTransfer>
                                            <feFuncA type="table" tableValues="0 .055"></feFuncA>
                                        </feComponentTransfer>
                                        <feBlend in="SourceGraphic" mode="multiply"></feBlend>
                                    </filter>
                                    <radialGradient id="softHighlight" cx="43%" cy="24%" r="64%">
                                        <stop offset="0%" stop-color="#ffffff" stop-opacity=".55"></stop>
                                        <stop offset="48%" stop-color="#ffffff" stop-opacity=".14"></stop>
                                        <stop offset="100%" stop-color="#ffffff" stop-opacity="0"></stop>
                                    </radialGradient>
                                    <linearGradient id="softShade" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#ffffff" stop-opacity="0"></stop>
                                        <stop offset="54%" stop-color="#000000" stop-opacity=".08"></stop>
                                        <stop offset="100%" stop-color="#000000" stop-opacity=".18"></stop>
                                    </linearGradient>
                                </defs>
                                <g class="product-group product-tshirt">
                                    <ellipse class="product-shadow" cx="300" cy="520" rx="150" ry="22"></ellipse>
                                    <path class="product-fill" d="M214 112 L258 82 H342 L386 112 L518 190 L460 292 L404 260 L404 512 H196 L196 260 L140 292 L82 190 Z"></path>
                                    <path class="product-highlight" d="M222 126 L262 102 Q300 126 338 102 L378 126 L380 500 H220 Z"></path>
                                    <path class="product-panel" d="M216 126 L258 100 Q300 128 342 100 L384 126 L380 512 H220 Z"></path>
                                    <path class="product-edge" d="M214 112 L258 82 H342 L386 112 L518 190 L460 292 L404 260 L404 512 H196 L196 260 L140 292 L82 190 Z"></path>
                                    <path class="product-stitch" d="M258 86 Q300 130 342 86 M196 258 L196 492 M404 258 L404 492"></path>
                                </g>
                                <g class="product-group product-hoodie">
                                    <ellipse class="product-shadow" cx="300" cy="522" rx="160" ry="24"></ellipse>
                                    <path class="product-fill" d="M214 160 Q238 92 300 82 Q362 92 386 160 L482 232 L442 336 L400 308 L410 522 H190 L200 308 L158 336 L118 232 Z"></path>
                                    <path class="product-highlight" d="M226 174 Q248 116 300 106 Q352 116 374 174 L386 510 H214 Z"></path>
                                    <path class="product-panel" d="M242 144 Q300 104 358 144 L376 224 Q342 206 300 206 Q258 206 224 224 Z"></path>
                                    <path class="product-panel" d="M232 386 H368 Q358 462 300 462 Q242 462 232 386 Z"></path>
                                    <path class="product-edge" d="M214 160 Q238 92 300 82 Q362 92 386 160 L482 232 L442 336 L400 308 L410 522 H190 L200 308 L158 336 L118 232 Z"></path>
                                    <path class="product-stitch" d="M268 164 L254 238 M332 164 L346 238 M232 386 H368"></path>
                                </g>
                                <g class="product-group product-cap">
                                    <ellipse class="product-shadow" cx="300" cy="390" rx="170" ry="22"></ellipse>
                                    <path class="product-fill" d="M124 300 Q160 176 300 166 Q440 176 476 300 Q396 346 300 346 Q204 346 124 300 Z"></path>
                                    <path class="product-fill" d="M260 336 Q370 330 510 358 Q420 410 286 386 Q230 376 154 350 Q206 340 260 336 Z"></path>
                                    <path class="product-highlight" d="M154 290 Q190 198 300 190 Q410 198 446 290 Q380 322 300 322 Q220 322 154 290 Z"></path>
                                    <path class="product-panel" d="M300 168 Q335 236 334 344 Q300 356 266 344 Q265 236 300 168 Z"></path>
                                    <path class="product-edge" d="M124 300 Q160 176 300 166 Q440 176 476 300 Q396 346 300 346 Q204 346 124 300 Z M260 336 Q370 330 510 358 Q420 410 286 386 Q230 376 154 350 Q206 340 260 336 Z"></path>
                                    <path class="product-stitch" d="M208 198 Q250 254 246 340 M392 198 Q350 254 354 340"></path>
                                </g>
                                <g class="product-group product-mug">
                                    <ellipse class="product-shadow" cx="300" cy="492" rx="142" ry="22"></ellipse>
                                    <path class="product-fill" d="M180 128 H388 Q416 128 416 156 V448 Q416 480 384 480 H184 Q152 480 152 448 V156 Q152 128 180 128 Z"></path>
                                    <path class="product-highlight" d="M190 148 H292 Q258 224 258 460 H176 V168 Q176 148 190 148 Z"></path>
                                    <path class="product-edge" d="M180 128 H388 Q416 128 416 156 V448 Q416 480 384 480 H184 Q152 480 152 448 V156 Q152 128 180 128 Z"></path>
                                    <path class="product-edge" d="M416 220 Q492 220 492 304 Q492 390 416 390 M416 260 Q454 260 454 304 Q454 350 416 350"></path>
                                    <path class="product-panel" d="M190 146 H378 Q396 146 396 164 V450 H172 V164 Q172 146 190 146 Z"></path>
                                </g>
                                <g class="product-group product-polo">
                                    <ellipse class="product-shadow" cx="300" cy="522" rx="150" ry="22"></ellipse>
                                    <path class="product-fill" d="M218 112 L258 84 H342 L382 112 L500 184 L452 286 L398 256 L406 514 H194 L202 256 L148 286 L100 184 Z"></path>
                                    <path class="product-highlight" d="M226 126 L260 102 L300 150 L340 102 L374 126 L386 500 H214 Z"></path>
                                    <path class="product-panel" d="M258 86 L300 138 L342 86 L376 122 L330 178 H270 L224 122 Z"></path>
                                    <path class="product-edge" d="M218 112 L258 84 H342 L382 112 L500 184 L452 286 L398 256 L406 514 H194 L202 256 L148 286 L100 184 Z"></path>
                                    <path class="product-stitch" d="M300 138 V240 M286 176 H314 M286 204 H314"></path>
                                </g>
                                <g class="product-group product-sweater">
                                    <ellipse class="product-shadow" cx="300" cy="522" rx="160" ry="22"></ellipse>
                                    <path class="product-fill" d="M204 118 L252 86 H348 L396 118 L526 220 L470 334 L412 292 L420 512 H180 L188 292 L130 334 L74 220 Z"></path>
                                    <path class="product-highlight" d="M216 132 L254 104 Q300 128 346 104 L384 132 L388 500 H212 Z"></path>
                                    <path class="product-panel" d="M252 92 Q300 130 348 92 L382 122 L380 512 H220 L218 122 Z"></path>
                                    <path class="product-edge" d="M204 118 L252 86 H348 L396 118 L526 220 L470 334 L412 292 L420 512 H180 L188 292 L130 334 L74 220 Z"></path>
                                    <path class="product-stitch" d="M250 92 Q300 126 350 92 M188 292 L180 500 M412 292 L420 500"></path>
                                </g>
                                <g class="product-group product-kids">
                                    <ellipse class="product-shadow" cx="300" cy="515" rx="128" ry="20"></ellipse>
                                    <path class="product-fill" d="M230 126 L266 104 H334 L370 126 L474 190 L426 274 L382 250 L388 494 H212 L218 250 L174 274 L126 190 Z"></path>
                                    <path class="product-highlight" d="M238 138 L268 118 Q300 140 332 118 L362 138 L366 484 H234 Z"></path>
                                    <path class="product-panel" d="M232 140 L266 118 Q300 146 334 118 L368 140 L364 494 H236 Z"></path>
                                    <path class="product-edge" d="M230 126 L266 104 H334 L370 126 L474 190 L426 274 L382 250 L388 494 H212 L218 250 L174 274 L126 190 Z"></path>
                                    <path class="product-stitch" d="M266 108 Q300 142 334 108 M218 250 L212 480 M382 250 L388 480"></path>
                                </g>
                            </svg>
                            <div class="print-area" id="printArea">
                                <div class="design-layer design-text" id="defaultText" data-layer-item>Aurix</div>
                            </div>
                        </div>
                        <div class="selected-box" id="selectedBox"></div>
                    </div>
                    <div class="flip-panel">
                        <button type="button" data-view="front">↑</button>
                        <span>FLIP</span>
                        <button type="button" data-view="back">↓</button>
                    </div>
                </div>
            </section>
        </main>

        <footer class="bottombar">
            <span>Notes</span>
            <div class="zoom">
                <input id="zoomRange" type="range" min="70" max="130" value="100">
                <span id="zoomLabel">100%</span>
                <span>Pages 1 / 1</span>
            </div>
        </footer>
    </div>

    <script>
        const state = {
            product: 'tshirt',
            productLabel: 'Tshirt',
            color: '#ffffff',
            view: 'front',
            selected: document.getElementById('defaultText'),
            history: [],
            redo: [],
        };

        const mockup = document.getElementById('mockup');
        const mockupImage = document.getElementById('mockupImage');
        const printArea = document.getElementById('printArea');
        const selectedBox = document.getElementById('selectedBox');
        const productList = document.getElementById('productList');
        const uploadInput = document.getElementById('uploadInput');
        const textInput = document.getElementById('textInput');
        const fontSelect = document.getElementById('fontSelect');
        const opacityRange = document.getElementById('opacityRange');
        const sizeRange = document.getElementById('sizeRange');
        const zoomRange = document.getElementById('zoomRange');
        const zoomLabel = document.getElementById('zoomLabel');

        function saveHistory() {
            state.history.push(printArea.innerHTML);
            if (state.history.length > 30) state.history.shift();
            state.redo = [];
        }

        function colorLuminance(hex) {
            const value = (hex || '#ffffff').replace('#', '');
            const rgb = [0, 2, 4].map(index => {
                const component = parseInt(value.slice(index, index + 2), 16);
                return Number.isNaN(component) ? 255 : component;
            });
            const channel = rgb.map(component => {
                const scaled = component / 255;
                return scaled <= 0.03928 ? scaled / 12.92 : Math.pow((scaled + 0.055) / 1.055, 2.4);
            });
            return 0.2126 * channel[0] + 0.7152 * channel[1] + 0.0722 * channel[2];
        }

        function applyProductColor(color) {
            const normalized = (color || '#ffffff').toLowerCase();
            state.color = normalized;
            mockup.style.setProperty('--product-color', normalized);
            mockup.dataset.colorMode = normalized === '#ffffff' ? 'white' : (colorLuminance(normalized) < 0.22 ? 'deep' : 'color');
            mockup.setAttribute('aria-label', `Selected ${state.productLabel} color ${normalized}`);
        }

        function activeProductButton() {
            return document.querySelector(`[data-product="${state.product}"]`);
        }

        function applyProductView(button = activeProductButton()) {
            if (!button) return;

            const view = state.view === 'back' ? 'back' : 'front';
            mockupImage.src = button.dataset[`${view}Image`];
            mockupImage.alt = `${state.productLabel} ${view} mockup`;
            mockup.style.setProperty('--product-mask-image', `url("${button.dataset[`${view}Mask`] || button.dataset[`${view}Image`]}")`);
            mockup.style.setProperty('--print-left', button.dataset[`${view}PrintLeft`]);
            mockup.style.setProperty('--print-top', button.dataset[`${view}PrintTop`]);
            mockup.style.setProperty('--print-width', button.dataset[`${view}PrintWidth`]);
            mockup.style.setProperty('--print-height', button.dataset[`${view}PrintHeight`]);
            mockup.style.transform = 'none';
            printArea.style.transform = 'none';
            updateSelectionBox();
        }

        function setSelected(layer) {
            state.selected = layer;
            updateSelectionBox();
            if (!layer) return;
            opacityRange.value = Math.round((parseFloat(layer.style.opacity || '1')) * 100);
            const size = layer.classList.contains('design-image') ? parseInt(layer.style.width || 180, 10) : parseInt(layer.style.fontSize || 34, 10) * 4;
            sizeRange.value = Number.isFinite(size) ? Math.min(300, Math.max(40, size)) : 180;
        }

        function updateSelectionBox() {
            if (!state.selected) {
                selectedBox.style.display = 'none';
                return;
            }
            const canvasRect = document.getElementById('canvas').getBoundingClientRect();
            const layerRect = state.selected.getBoundingClientRect();
            selectedBox.style.display = 'block';
            selectedBox.style.left = `${layerRect.left - canvasRect.left}px`;
            selectedBox.style.top = `${layerRect.top - canvasRect.top}px`;
            selectedBox.style.width = `${layerRect.width}px`;
            selectedBox.style.height = `${layerRect.height}px`;
        }

        function activateLayer(layer) {
            layer.setAttribute('data-layer-item', '');
            layer.addEventListener('pointerdown', startDrag);
            layer.addEventListener('click', () => setSelected(layer));
            setSelected(layer);
        }

        document.querySelectorAll('[data-layer-item]').forEach(activateLayer);

        function startDrag(event) {
            const layer = event.currentTarget;
            setSelected(layer);
            const startX = event.clientX;
            const startY = event.clientY;
            const rect = layer.getBoundingClientRect();
            const parent = printArea.getBoundingClientRect();
            const offsetX = rect.left - parent.left;
            const offsetY = rect.top - parent.top;
            layer.setPointerCapture(event.pointerId);
            saveHistory();

            function move(moveEvent) {
                const x = offsetX + moveEvent.clientX - startX;
                const y = offsetY + moveEvent.clientY - startY;
                layer.style.left = `${x}px`;
                layer.style.top = `${y}px`;
                layer.style.transform = 'none';
                updateSelectionBox();
            }

            function up() {
                layer.removeEventListener('pointermove', move);
                layer.removeEventListener('pointerup', up);
            }

            layer.addEventListener('pointermove', move);
            layer.addEventListener('pointerup', up);
        }

        document.querySelectorAll('[data-product]').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('[data-product]').forEach(item => item.classList.remove('is-active'));
                button.classList.add('is-active');
                state.product = button.dataset.product;
                state.productLabel = button.dataset.label;
                mockup.className = `mockup ${state.product}`;
                mockup.dataset.light = button.dataset.light || 'light';
                applyProductView(button);
                applyProductColor(state.color);
                updateSelectionBox();
            });
        });

        document.querySelectorAll('.swatch').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.swatch').forEach(item => item.classList.remove('is-active'));
                button.classList.add('is-active');
                applyProductColor(button.dataset.color);
            });
        });

        applyProductColor(state.color);

        document.querySelectorAll('[data-view]').forEach(button => {
            button.addEventListener('click', () => {
                state.view = button.dataset.view;
                document.querySelectorAll('[data-view]').forEach(item => item.classList.toggle('is-active', item.dataset.view === state.view));
                applyProductView();
            });
        });

        document.querySelectorAll('[data-add-text]').forEach(button => {
            button.addEventListener('click', () => {
                saveHistory();
                const layer = document.createElement('div');
                layer.className = 'design-layer design-text';
                layer.textContent = textInput.value || 'Aurix';
                layer.style.fontFamily = fontSelect.value;
                printArea.appendChild(layer);
                activateLayer(layer);
            });
        });

        uploadInput.addEventListener('change', event => {
            const file = event.target.files?.[0];
            if (!file) return;
            saveHistory();
            const reader = new FileReader();
            reader.onload = () => {
                const img = document.createElement('img');
                img.className = 'design-layer design-image';
                img.src = reader.result;
                img.alt = 'Uploaded design';
                printArea.appendChild(img);
                activateLayer(img);
            };
            reader.readAsDataURL(file);
        });

        document.querySelectorAll('[data-upload-shortcut]').forEach(button => button.addEventListener('click', () => uploadInput.click()));
        document.querySelectorAll('[data-focus-text]').forEach(button => button.addEventListener('click', () => textInput.focus()));

        document.querySelector('[data-center-x]').addEventListener('click', () => {
            if (!state.selected) return;
            state.selected.style.left = '50%';
            state.selected.style.transform = 'translateX(-50%)';
            updateSelectionBox();
        });

        document.querySelector('[data-center-y]').addEventListener('click', () => {
            if (!state.selected) return;
            state.selected.style.top = '50%';
            state.selected.style.transform = `${state.selected.style.transform || ''} translateY(-50%)`;
            updateSelectionBox();
        });

        opacityRange.addEventListener('input', () => {
            if (state.selected) state.selected.style.opacity = opacityRange.value / 100;
        });

        sizeRange.addEventListener('input', () => {
            if (!state.selected) return;
            if (state.selected.classList.contains('design-image')) {
                state.selected.style.width = `${sizeRange.value}px`;
            } else {
                state.selected.style.fontSize = `${Math.max(14, sizeRange.value / 4)}px`;
            }
            updateSelectionBox();
        });

        fontSelect.addEventListener('change', () => {
            if (state.selected?.classList.contains('design-text')) state.selected.style.fontFamily = fontSelect.value;
        });

        document.querySelectorAll('[data-delete]').forEach(button => button.addEventListener('click', () => {
            if (!state.selected) return;
            saveHistory();
            state.selected.remove();
            setSelected(printArea.querySelector('[data-layer-item]'));
        }));

        document.querySelector('[data-duplicate]').addEventListener('click', () => {
            if (!state.selected) return;
            saveHistory();
            const clone = state.selected.cloneNode(true);
            clone.style.left = '54%';
            clone.style.top = '54%';
            printArea.appendChild(clone);
            activateLayer(clone);
        });

        document.querySelector('[data-layer="front"]').addEventListener('click', () => state.selected && (state.selected.style.zIndex = String((parseInt(state.selected.style.zIndex || 5, 10)) + 1)));
        document.querySelector('[data-layer="back"]').addEventListener('click', () => state.selected && (state.selected.style.zIndex = String(Math.max(1, (parseInt(state.selected.style.zIndex || 5, 10)) - 1))));
        document.querySelector('[data-flip-h]').addEventListener('click', () => state.selected && (state.selected.style.scale = state.selected.style.scale === '-1 1' ? '1 1' : '-1 1'));
        document.querySelector('[data-flip-v]').addEventListener('click', () => state.selected && (state.selected.style.scale = state.selected.style.scale === '1 -1' ? '1 1' : '1 -1'));

        document.querySelector('[data-undo]').addEventListener('click', () => {
            const previous = state.history.pop();
            if (!previous) return;
            state.redo.push(printArea.innerHTML);
            printArea.innerHTML = previous;
            document.querySelectorAll('[data-layer-item]').forEach(activateLayer);
        });

        document.querySelector('[data-redo]').addEventListener('click', () => {
            const next = state.redo.pop();
            if (!next) return;
            state.history.push(printArea.innerHTML);
            printArea.innerHTML = next;
            document.querySelectorAll('[data-layer-item]').forEach(activateLayer);
        });

        document.querySelector('[data-fit]').addEventListener('click', () => {
            zoomRange.value = 100;
            document.getElementById('canvas').style.transform = 'scale(1)';
            zoomLabel.textContent = '100%';
        });

        zoomRange.addEventListener('input', () => {
            document.getElementById('canvas').style.transform = `scale(${zoomRange.value / 100})`;
            document.getElementById('canvas').style.transformOrigin = 'top center';
            zoomLabel.textContent = `${zoomRange.value}%`;
        });

        document.querySelector('[data-save]').addEventListener('click', () => {
            const design = { product: state.productLabel, color: state.color, view: state.view, html: printArea.innerHTML };
            localStorage.setItem('aurixStudioDesign', JSON.stringify(design));
            alert('Design saved on this device.');
        });

        document.querySelector('[data-add-cart]').addEventListener('click', () => {
            const cart = JSON.parse(localStorage.getItem('aurixCart') || '[]');
            cart.push({ id: `custom-${Date.now()}`, name: `Custom ${state.productLabel}`, price: 0, quantity: 1, image: '', customDesign: true });
            localStorage.setItem('aurixCart', JSON.stringify(cart));
            alert('Custom design added to cart.');
        });

        document.querySelector('[data-share]').addEventListener('click', async () => {
            const text = `Aurix Studio design: ${state.productLabel}, ${state.view} view`;
            if (navigator.share) {
                await navigator.share({ title: 'Aurix Studio Design', text, url: window.location.href });
            } else {
                await navigator.clipboard.writeText(window.location.href);
                alert('Studio link copied.');
            }
        });

        window.addEventListener('resize', updateSelectionBox);
        updateSelectionBox();
    </script>
</body>
</html>

