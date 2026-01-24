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
            <div class="grid lg:grid-cols-12 gap-8">
                <article class="prose prose-lg max-w-none prose-slate lg:col-span-8">
                    {!! nl2br(e($post->body)) !!}
                </article>

                <aside class="lg:col-span-4 space-y-6">
                    <div class="border border-slate-200 rounded-xl p-4 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="h-14 w-14 rounded-full bg-slate-200 flex items-center justify-center text-lg font-semibold text-slate-700">
                                {{ strtoupper(substr($post->author_name ?? 'A',0,1)) }}
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

                    <div class="border border-slate-200 rounded-xl p-4 shadow-sm">
                        <p class="text-xs uppercase text-slate-500 mb-2">Table of contents</p>
                        <ul class="space-y-2 text-sm text-slate-700 list-disc list-inside">
                            <li>Overview</li>
                            <li>Key takeaways</li>
                            <li>How to apply this</li>
                            <li>Further reading</li>
                        </ul>
                        <p class="text-xs text-slate-500 mt-3">Tip: add H2/H3 headings in the editor to build a richer outline.</p>
                    </div>
                </aside>
            </div>
        </section>
    </main>
</body>
</html>
