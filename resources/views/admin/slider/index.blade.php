@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Slider Images</h1>
        <p class="text-slate-500 text-sm">Upload and order homepage hero slides.</p>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-4">
    <div class="card p-4">
        <h2 class="text-lg font-semibold mb-3">{{ isset($sliderImage) ? 'Edit Slide' : 'Add Slide' }}</h2>
        <form action="{{ isset($sliderImage) ? route('admin.slider-images.update', $sliderImage) : route('admin.slider-images.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
            @csrf
            @if(isset($sliderImage))
                @method('PUT')
            @endif
            <div>
                <label class="text-sm font-semibold text-slate-800">Title</label>
                <input type="text" name="title" value="{{ old('title', $sliderImage->title ?? '') }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-800">Caption</label>
                <input type="text" name="caption" value="{{ old('caption', $sliderImage->caption ?? '') }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2">
            </div>
            <div class="grid md:grid-cols-2 gap-3">
                <div>
                    <label class="text-sm font-semibold text-slate-800">Button Text</label>
                    <input type="text" name="button_text" value="{{ old('button_text', $sliderImage->button_text ?? '') }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2">
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Button URL</label>
                    <input type="text" name="button_url" value="{{ old('button_url', $sliderImage->button_url ?? '') }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2">
                </div>
            </div>
            <div class="grid md:grid-cols-2 gap-3">
                <div>
                    <label class="text-sm font-semibold text-slate-800">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $sliderImage->sort_order ?? 0) }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2">
                </div>
                <div class="flex items-center gap-2 pt-6">
                    <input type="checkbox" name="is_active" value="1" class="accent-sky-600" {{ old('is_active', $sliderImage->is_active ?? true) ? 'checked' : '' }}>
                    <span class="text-sm text-slate-700">Active</span>
                </div>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-800">Image {{ isset($sliderImage) ? '(leave blank to keep current)' : '' }}</label>
                <input type="file" name="image" class="w-full bg-white border border-slate-200 rounded px-3 py-2">
                @isset($sliderImage)
                    @if($sliderImage->image_url)
                        <div class="mt-2">
                            <img src="{{ $sliderImage->image_url }}" alt="" class="h-20 rounded border border-slate-200 object-cover">
                        </div>
                    @endif
                @endisset
            </div>
            <button class="px-5 py-2 rounded bg-sky-600 text-white font-semibold hover:bg-sky-500" type="submit">
                {{ isset($sliderImage) ? 'Update Slide' : 'Add Slide' }}
            </button>
        </form>
    </div>

    <div class="card p-4">
        <h2 class="text-lg font-semibold mb-3">Current Slides</h2>
        <div class="space-y-3">
            @forelse($slides as $slide)
                <div class="flex items-center gap-3 border border-slate-200 rounded p-2">
                    @if($slide->image_url)
                        <img src="{{ $slide->image_url }}" alt="" class="h-14 w-20 object-cover rounded">
                    @else
                        <div class="h-14 w-20 rounded bg-slate-100 flex items-center justify-center text-xs text-slate-400">No image</div>
                    @endif
                    <div class="flex-1">
                        <div class="font-semibold text-slate-900">{{ $slide->title ?? 'Untitled' }}</div>
                        <div class="text-xs text-slate-500">Order: {{ $slide->sort_order }} | {{ $slide->is_active ? 'Active' : 'Hidden' }}</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.slider-images.edit', $slide) }}" class="text-sky-600 font-semibold text-sm">Edit</a>
                        <form action="{{ route('admin.slider-images.destroy', $slide) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-rose-500 text-sm" onclick="return confirm('Delete this slide?')">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-slate-500 text-sm">No slides uploaded.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
