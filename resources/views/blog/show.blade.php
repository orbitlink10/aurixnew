<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->seo_title ?? $post->title }}</title>
    <meta name="description" content="{{ $post->meta_description ?? '' }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }

        .article-body {
            color: #0f172a;
            font-size: 1.12rem;
            line-height: 1.85;
        }

        .article-body > * + * {
            margin-top: 1.35rem;
        }

        .article-body h2,
        .article-body h3,
        .article-body h4 {
            color: #111827;
            font-weight: 800;
            line-height: 1.15;
            scroll-margin-top: 2rem;
        }

        .article-body h2 {
            margin-top: 3rem;
            font-size: clamp(2rem, 4vw, 3.25rem);
        }

        .article-body h3 {
            margin-top: 2.25rem;
            font-size: clamp(1.5rem, 3vw, 2rem);
        }

        .article-body h4 {
            margin-top: 1.75rem;
            font-size: 1.25rem;
        }

        .article-body p {
            margin: 0;
        }

        .article-body a {
            color: #0b72d2;
            font-weight: 700;
            text-decoration: underline;
            text-underline-offset: 4px;
        }

        .article-body ul,
        .article-body ol {
            padding-left: 1.4rem;
        }

        .article-body ul {
            list-style: disc;
        }

        .article-body ol {
            list-style: decimal;
        }

        .article-body li + li {
            margin-top: 0.55rem;
        }

        .article-body blockquote {
            border-left: 4px solid #0b72d2;
            background: #f8fafc;
            color: #334155;
            margin: 2rem 0;
            padding: 1rem 1.25rem;
            font-weight: 600;
        }

        .article-body img {
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            margin: 2rem 0;
            max-width: 100%;
            height: auto;
        }

        .article-body table {
            display: block;
            width: 100%;
            overflow-x: auto;
            border-collapse: collapse;
            margin: 2rem 0;
            font-size: 1rem;
        }

        .article-body th,
        .article-body td {
            border: 1px solid #dbe3ef;
            padding: 0.85rem 1rem;
            text-align: left;
            vertical-align: top;
        }

        .article-body th {
            background: #f1f5f9;
            font-weight: 800;
        }

        .toc-link[data-level="3"] {
            padding-left: 1rem;
        }

        @media (max-width: 768px) {
            .article-body {
                font-size: 1.02rem;
                line-height: 1.75;
            }
        }
    </style>
</head>
@php
    $preparedContent = \App\Support\BlogContent::prepare($post->body);
@endphp
<body class="bg-white text-slate-900">
    <header class="border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-5 py-4 flex items-center justify-between text-sm">
            <div class="flex items-center gap-3 font-semibold text-slate-800">
                <a href="{{ url('/') }}" class="text-sky-600">Aurix</a>
                <span class="text-slate-400">&bull;</span>
                <span>Blog</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="text-slate-600 hover:text-slate-900">Home</a>
                <a href="{{ url('/#contact') }}" class="text-slate-600 hover:text-slate-900">Contact</a>
            </div>
        </div>
    </header>

    <main>
        <section class="bg-[#0b72d2] text-white">
            <div class="max-w-6xl mx-auto px-5 py-12">
                <div class="text-sm mb-4 flex items-center gap-2">
                    <a href="{{ url('/') }}" class="underline-offset-4 hover:underline">Aurix</a>
                    <span>&rsaquo;</span>
                    <a href="{{ url('/blog-posts/'.$post->slug) }}" class="underline-offset-4 hover:underline">Blog</a>
                    @if($post->category)
                        <span>&rsaquo;</span>
                        <span>{{ $post->category->name }}</span>
                    @endif
                </div>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight">{{ $post->title }}</h1>
                <div class="mt-4 text-base flex flex-wrap gap-4 text-sky-100">
                    <span>Author: {{ $post->author_name ?? 'Aurix Editorial' }}</span>
                    <span>&bull;</span>
                    <span>{{ $readingTime }} min read</span>
                    <span>&bull;</span>
                    <span>{{ $post->published_at?->format('M d, Y') ?? 'Unpublished' }}</span>
                </div>
            </div>
        </section>

        <section class="max-w-6xl mx-auto px-5 py-10">
            @if($post->cover_image)
                <img
                    src="{{ asset('storage/'.$post->cover_image) }}"
                    alt="{{ $post->image_alt_text ?: $post->title }}"
                    class="w-full rounded-2xl border border-slate-200 shadow mb-8"
                >
            @endif

            <div class="grid lg:grid-cols-12 gap-8">
                <article class="article-body lg:col-span-8">
                    {!! $preparedContent['html'] !!}
                </article>

                <aside class="lg:col-span-4 space-y-6">
                    <div class="border border-slate-200 rounded-xl p-4 shadow-sm lg:sticky lg:top-6">
                        <div class="flex items-center gap-3">
                            <div class="h-14 w-14 rounded-full bg-slate-200 flex items-center justify-center text-lg font-semibold text-slate-700">
                                {{ strtoupper(substr($post->author_name ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-slate-900">{{ $post->author_name ?? 'Aurix Editorial' }}</div>
                                <div class="text-sm text-slate-500">{{ $readingTime }} min read</div>
                            </div>
                        </div>
                        <p class="text-sm text-slate-600 mt-3">
                            {{ $post->meta_description ?? 'Insights from the Aurix team on branding, strategy, and digital experiences.' }}
                        </p>
                        <div class="mt-4">
                            <p class="text-xs uppercase text-slate-500 mb-2">Share</p>
                            <div class="flex gap-3 text-slate-600">
                                <a href="#" class="hover:text-slate-900">LinkedIn</a>
                                <a href="#" class="hover:text-slate-900">Twitter</a>
                                <a href="#" class="hover:text-slate-900">Email</a>
                            </div>
                        </div>
                    </div>

                    @if(count($preparedContent['toc']))
                        <nav class="border border-slate-200 rounded-xl p-4 shadow-sm lg:sticky lg:top-56" aria-label="Table of contents">
                            <p class="text-2xl font-extrabold text-slate-900 mb-4">Table of contents</p>
                            <ul class="space-y-3 text-sm text-slate-700">
                                @foreach($preparedContent['toc'] as $item)
                                    <li>
                                        <a
                                            href="#{{ $item['id'] }}"
                                            class="toc-link block font-bold leading-snug hover:text-sky-700"
                                            data-level="{{ $item['level'] }}"
                                        >{{ $item['text'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    @endif
                </aside>
            </div>
        </section>
    </main>
</body>
</html>
