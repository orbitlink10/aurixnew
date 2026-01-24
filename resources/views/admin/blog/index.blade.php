@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Blog Posts</h1>
        <p class="text-slate-500 text-sm">Manage content, categories, tags, and SEO.</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.blog-posts.create') }}" class="px-4 py-2 rounded bg-sky-600 text-white font-semibold hover:bg-sky-500">New Post</a>
    </div>
</div>

<div class="card p-4">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="text-slate-500">
                <tr>
                    <th class="text-left py-2">Title</th>
                    <th class="text-left py-2">Category</th>
                    <th class="text-left py-2">Status</th>
                    <th class="text-left py-2">Published</th>
                    <th class="text-left py-2">Views</th>
                    <th class="text-right py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr class="border-t border-slate-200">
                        <td class="py-2">
                            <div class="font-semibold text-slate-900">{{ $post->title }}</div>
                            <div class="text-slate-500 text-xs">{{ $post->slug }}</div>
                        </td>
                        <td class="py-2 text-slate-700">{{ $post->category->name ?? '—' }}</td>
                        <td class="py-2">
                            <span class="px-2 py-1 rounded text-xs {{ $post->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>
                        <td class="py-2 text-slate-700">{{ $post->published_at ? $post->published_at->format('Y-m-d') : '—' }}</td>
                        <td class="py-2 text-slate-700">{{ $post->view_count }}</td>
                        <td class="py-2 text-right space-x-3">
                            @if($post->status === 'published')
                                <a class="text-emerald-600 font-semibold" target="_blank" href="{{ url('/blog/'.$post->slug) }}">View</a>
                            @endif
                            <a class="text-sky-600 font-semibold" href="{{ route('admin.blog-posts.edit', $post) }}">Edit</a>
                            <form action="{{ route('admin.blog-posts.destroy', $post) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-rose-500" onclick="return confirm('Delete this post?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td class="py-3 text-slate-500" colspan="6">No posts yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $posts->links() }}</div>
</div>
@endsection
