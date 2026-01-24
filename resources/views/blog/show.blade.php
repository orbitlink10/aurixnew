<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->seo_title ?? $post->title }}</title>
    <meta name="description" content="{{ $post->meta_description ?? '' }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="max-w-5xl mx-auto px-4 py-8">
        <a href="{{ url('/') }}" class="text-sky-600 font-semibold text-sm">← Home</a>
        <article class="mt-4 bg-white p-6 rounded-xl border border-slate-200 shadow">
            <p class="text-xs uppercase text-slate-500">{{ $post->published_at?->format('M d, Y') }}</p>
            <h1 class="text-3xl font-bold mt-1 mb-2">{{ $post->title }}</h1>
            @if($post->category)
                <span class="text-sm text-slate-600">{{ $post->category->name }}</span>
            @endif
            <div class="prose prose-slate mt-4 max-w-none">
                {!! nl2br(e($post->body)) !!}
            </div>
        </article>
    </div>
</body>
</html>
