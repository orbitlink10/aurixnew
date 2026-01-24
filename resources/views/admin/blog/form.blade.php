@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">{{ isset($post) ? 'Edit Post' : 'Create Post' }}</h1>
        <p class="text-slate-500 text-sm">Optimize SEO fields and publish.</p>
    </div>
    <a href="{{ route('admin.blog-posts.index') }}" class="px-4 py-2 rounded border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50">Back</a>
</div>

<div class="card p-5">
    <form method="POST" action="{{ isset($post) && $post->exists ? route('admin.blog-posts.update', $post) : route('admin.blog-posts.store') }}">
        @csrf
        @if(isset($post) && $post->exists)
            @method('PUT')
        @endif
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-800 mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2 text-slate-900" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-800 mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $post->slug ?? '') }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2 text-slate-900">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-800 mb-1">SEO Title</label>
                <input type="text" name="seo_title" value="{{ old('seo_title', $post->seo_title ?? '') }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2 text-slate-900">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-800 mb-1">Meta Description</label>
                <input type="text" name="meta_description" value="{{ old('meta_description', $post->meta_description ?? '') }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2 text-slate-900">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-800 mb-1">Category</label>
                <select name="category_id" class="w-full bg-white border border-slate-200 rounded px-3 py-2 text-slate-900">
                    <option value="">--</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('category_id', $post->category_id ?? '') == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-800 mb-1">Status</label>
                <select name="status" class="w-full bg-white border border-slate-200 rounded px-3 py-2 text-slate-900">
                    @foreach(['draft','published'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $post->status ?? 'draft') == $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-800 mb-1">Tags</label>
                <select name="tag_ids[]" multiple class="w-full bg-white border border-slate-200 rounded px-3 py-2 text-slate-900">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" @selected(collect(old('tag_ids', isset($post) ? $post->tags->pluck('id')->toArray() : []))->contains($tag->id))>{{ $tag->name }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-500 mt-1">Hold Ctrl/Cmd to select multiple.</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-800 mb-1">Published At</label>
                <input type="datetime-local" name="published_at" value="{{ old('published_at', isset($post) && $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2 text-slate-900">
            </div>
        </div>
        <div class="mt-4">
            <label class="block text-sm font-semibold text-slate-800 mb-1">Excerpt</label>
            <textarea name="excerpt" rows="2" class="w-full bg-white border border-slate-200 rounded px-3 py-2 text-slate-900">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
        </div>
        <div class="mt-4">
            <label class="block text-sm font-semibold text-slate-800 mb-1">Body</label>
            <textarea name="body" rows="8" class="w-full bg-white border border-slate-200 rounded px-3 py-2 text-slate-900" required>{{ old('body', $post->body ?? '') }}</textarea>
        </div>
        <div class="mt-4 flex items-center gap-3">
            <button class="px-5 py-2 rounded bg-sky-600 text-white font-semibold hover:bg-sky-500" type="submit">
                {{ isset($post) ? 'Update Post' : 'Create Post' }}
            </button>
            <a href="{{ route('admin.blog-posts.index') }}" class="px-5 py-2 rounded border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50">Cancel</a>
        </div>
    </form>
</div>
@endsection
