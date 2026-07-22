@extends('layouts.admin')

@section('content')
<section class="content-header mb-6">
    <div>
        <h1 class="page-title text-3xl mb-2">{{ $isEditing ? 'Edit Menu' : 'Add Menu' }}</h1>
        <p class="text-slate-500">{{ $isEditing ? 'Update the menu item details' : 'Fill in the details to add a new menu item' }}</p>
    </div>
</section>

<section class="content">
    <div class="card rounded-xl p-5">
        <form
            action="{{ $isEditing ? route('admin.home-page-content.main-menu.item.update', $menuIndex) : route('admin.home-page-content.main-menu.store') }}"
            method="POST"
            class="space-y-5"
        >
            @csrf
            @if($isEditing)
                @method('PUT')
            @endif

            <div>
                <label for="menuLabel" class="mb-2 block text-sm font-semibold text-slate-950">Name:</label>
                <input
                    id="menuLabel"
                    type="text"
                    name="label"
                    value="{{ old('label', $menuItem['label'] ?? '') }}"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-950 outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-100"
                    required
                >
                @error('label')
                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="menuUrl" class="mb-2 block text-sm font-semibold text-slate-950">URL:</label>
                <input
                    id="menuUrl"
                    type="text"
                    name="url"
                    value="{{ old('url', $menuItem['url'] ?? '') }}"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-950 outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-100"
                    placeholder="/products?category=women"
                    required
                >
                @error('url')
                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-wrap items-center gap-2 pt-1">
                <button type="submit" class="rounded-full bg-blue-600 px-5 py-2.5 font-semibold text-white hover:bg-blue-700">Save</button>
                <a href="{{ route('admin.home-page-content.index') }}" class="rounded-full bg-slate-600 px-5 py-2.5 font-semibold text-white hover:bg-slate-700">Cancel</a>
            </div>
        </form>
    </div>
</section>
@endsection
