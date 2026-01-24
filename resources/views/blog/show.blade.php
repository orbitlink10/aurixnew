<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->seo_title ?? $post->title }}</title>
    <meta name="description" content="{{ $post->meta_description ?? '' }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-slate-900">
    <header class="border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-5 py-4 flex items-center justify-between text-sm">
            <div class="flex items-center gap-3 font-semibold text-slate-800">
                <a href="{{ url('/') }}" class="text-sky-600">Aurix</a>
                <span class="text-slate-400">•</span>
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
                    <span>›</span>
                    <a href="{{ url('/blog-posts/'.$post->slug) }}" class="underline-offset-4 hover:underline">Blog</a>
                    @if($post->category)
                        <span>›</span>
                        <span>{{ $post->category->name }}</span>
                    @endif
                </div>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight">{{ $post->title }}</h1>
                <div class="mt-4 text-base flex flex-wrap gap-4 text-sky-100">
                    <span>Author: {{ $post->author_name ?? 'Aurix Editorial' }}</span>
                    <span>•</span>
                    <span>{{ $readingTime }} min read</span>
                    <span>•</span>
                    <span>{{ $post->published_at?->format('M d, Y') ?? 'Unpublished' }}</span>
                </div>
            </div>
        </section>

        <section class="max-w-6xl mx-auto px-5 py-10">
            @if($post->cover_image)
                <img src="{{ asset('storage/'.$post->cover_image) }}" alt="{{ $post->title }}" class="w-full rounded-2xl border border-slate-200 shadow mb-8">
            @endif
            <article class="prose prose-lg max-w-none prose-slate">
                {!! nl2br(e($post->body)) !!}
            </article>
        </section>
    </main>
</body>
</html>
