@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Work Categories</h1>
        <p class="text-slate-500 text-sm">Upload your completed work categories for the homepage showcase.</p>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-4">
    <div class="card p-4">
        <h2 class="text-lg font-semibold mb-3">{{ isset($editing) ? 'Edit Category' : 'Add Category' }}</h2>
        <form action="{{ isset($editing) ? route('admin.work-categories.update', $editing) : route('admin.work-categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
            @csrf
            @if(isset($editing))
                @method('PUT')
            @endif
            <div>
                <label class="text-sm font-semibold text-slate-800">Category Name</label>
                <input type="text" name="name" value="{{ old('name', $editing->name ?? '') }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2" required>
            </div>
            <div class="grid md:grid-cols-2 gap-3">
                <div>
                    <label class="text-sm font-semibold text-slate-800">Number of Items</label>
                    <input type="number" min="0" name="item_count" value="{{ old('item_count', $editing->item_count ?? 0) }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2">
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Sort Order</label>
                    <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $editing->sort_order ?? 0) }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2">
                </div>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" class="accent-sky-600" {{ old('is_active', $editing->is_active ?? true) ? 'checked' : '' }}>
                <span class="text-sm text-slate-700">Show on homepage</span>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-800">Category Image {{ isset($editing) ? '(leave blank to keep current)' : '' }}</label>
                <input type="file" name="image" accept="image/*" class="w-full bg-white border border-slate-200 rounded px-3 py-2" {{ isset($editing) ? '' : 'required' }}>
                @isset($editing)
                    @if($editing->image_url)
                        <div class="mt-2">
                            <img src="{{ $editing->image_url }}" alt="" class="h-20 w-20 rounded-full border border-slate-200 object-cover">
                        </div>
                    @endif
                @endisset
            </div>
            <button class="px-5 py-2 rounded bg-sky-600 text-white font-semibold hover:bg-sky-500" type="submit">
                {{ isset($editing) ? 'Update Category' : 'Add Category' }}
            </button>
            @isset($editing)
                <a href="{{ route('admin.work-categories.index') }}" class="inline-block ml-2 text-sm text-slate-600 hover:text-slate-900">Cancel edit</a>
            @endisset
        </form>
    </div>

    <div class="card p-4">
        <h2 class="text-lg font-semibold mb-3">Current Categories</h2>
        <div class="space-y-3">
            @forelse($workCategories as $category)
                <div class="flex items-center gap-3 border border-slate-200 rounded p-2">
                    @if($category->image_url)
                        <img src="{{ $category->image_url }}" alt="" class="h-14 w-14 object-cover rounded-full">
                    @else
                        <div class="h-14 w-14 rounded-full bg-slate-100 flex items-center justify-center text-xs text-slate-400">No image</div>
                    @endif
                    <div class="flex-1">
                        <div class="font-semibold text-slate-900">{{ $category->name }}</div>
                        <div class="text-xs text-slate-500">{{ $category->item_count }} {{ $category->item_count == 1 ? 'item' : 'items' }} | Order: {{ $category->sort_order }} | {{ $category->is_active ? 'Active' : 'Hidden' }}</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.work-categories.edit', $category) }}" class="text-sky-600 font-semibold text-sm">Edit</a>
                        <form action="{{ route('admin.work-categories.destroy', $category) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-rose-500 text-sm" onclick="return confirm('Delete this category?')">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-slate-500 text-sm">No categories uploaded.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
