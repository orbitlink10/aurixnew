@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-start justify-between">
    <div>
        <h1 class="text-3xl page-title mb-2">Home Page Content</h1>
        <p class="text-slate-500">Manage the homepage hero visuals and showcased work categories.</p>
    </div>
</div>

<div class="card rounded-xl overflow-hidden">
    <div class="flex flex-col gap-3 border-b border-slate-200 bg-white px-4 py-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">Main Website Menu</h2>
            <p class="text-sm text-slate-500 mt-1">Manage the black menu shown on the homepage and shop page.</p>
        </div>
        <a href="{{ route('admin.home-page-content.main-menu.create') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
            <i class="fa-solid fa-plus"></i> Add Menu
        </a>
    </div>
    <div class="p-4">
        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white">
            <div class="px-4 py-3">
                <h3 class="text-base font-semibold text-slate-950">Menu List</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="border-y border-slate-200 bg-slate-50 text-xs font-bold uppercase tracking-[0.22em] text-slate-500">
                            <th class="w-20 px-4 py-3">#</th>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">URL</th>
                            <th class="w-56 px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($mainMenuItems as $index => $menuItem)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-4 text-slate-700">{{ $index + 1 }}</td>
                                <td class="px-4 py-4 font-medium text-slate-950">{{ $menuItem['label'] ?? '' }}</td>
                                <td class="px-4 py-4 text-slate-700">{{ $menuItem['url'] ?? '' }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('admin.home-page-content.main-menu.edit', $index) }}" class="inline-flex items-center rounded-full border border-blue-500 px-3 py-1.5 text-sm font-semibold text-blue-600 hover:bg-blue-50">Edit</a>
                                        <form action="{{ route('admin.home-page-content.main-menu.destroy', $index) }}" method="POST" onsubmit="return confirm('Delete this menu item?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center rounded-full border border-rose-400 px-3 py-1.5 text-sm font-semibold text-rose-500 hover:bg-rose-50">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-slate-500">No menu items created.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card p-4 rounded-xl">
    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
        <div class="md:max-w-xl">
            <h2 class="text-lg font-semibold text-slate-900">Website Logo</h2>
            <p class="text-sm text-slate-500 mt-1">Upload the logo shown in the public homepage header.</p>
            @if($logoUrl)
                <div class="mt-3 inline-flex items-center gap-3 rounded-lg border border-slate-200 bg-white px-4 py-3">
                    <img src="{{ $logoUrl }}" alt="Current site logo" class="h-14 w-auto max-w-48 object-contain">
                    <span class="text-sm text-slate-500">Current logo</span>
                </div>
            @else
                <p class="text-sm text-slate-500 mt-3">No custom logo uploaded. The default Aurix mark is currently shown.</p>
            @endif
        </div>
        <div class="w-full md:max-w-sm space-y-2">
            <form action="{{ route('admin.site-settings.logo.store') }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                @csrf
                <input type="file" name="logo" accept="image/*" class="w-full bg-white border border-slate-200 rounded px-3 py-2 text-sm" required>
                <button type="submit" class="w-full px-4 py-2 rounded bg-sky-600 text-white font-semibold hover:bg-sky-500">Upload Logo</button>
            </form>
            @if($logoUrl)
                <form action="{{ route('admin.site-settings.logo.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 rounded border border-rose-200 text-rose-600 font-semibold hover:bg-rose-50" onclick="return confirm('Remove the custom site logo?')">Remove Logo</button>
                </form>
            @endif
        </div>
    </div>
</div>

<div class="card p-4 rounded-xl">
    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
        <div class="md:max-w-xl">
            <h2 class="text-lg font-semibold text-slate-900">Homepage Hero Visuals</h2>
            <p class="text-sm text-slate-500 mt-1">Upload multiple images for the hero panel. They rotate automatically every 3 seconds.</p>
            @if(count($heroImageUrls))
                <div class="mt-3 grid grid-cols-2 md:grid-cols-3 gap-2">
                    @foreach($heroImageUrls as $heroImageUrl)
                        <img src="{{ $heroImageUrl }}" alt="Homepage hero visual" class="h-24 w-full rounded-lg border border-slate-200 object-cover">
                    @endforeach
                </div>
            @else
                <p class="text-sm text-slate-500 mt-3">No custom images uploaded. The default artwork is currently shown.</p>
            @endif
        </div>
        <div class="w-full md:max-w-sm space-y-2">
            <form action="{{ route('admin.site-settings.home-hero-image.store') }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                @csrf
                <input type="file" name="hero_images[]" accept="image/*" multiple class="w-full bg-white border border-slate-200 rounded px-3 py-2 text-sm" required>
                <button type="submit" class="w-full px-4 py-2 rounded bg-sky-600 text-white font-semibold hover:bg-sky-500">Upload Hero Images</button>
            </form>
            @if(count($heroImageUrls))
                <form action="{{ route('admin.site-settings.home-hero-image.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 rounded border border-rose-200 text-rose-600 font-semibold hover:bg-rose-50" onclick="return confirm('Remove all custom homepage hero images?')">Remove All Custom Images</button>
                </form>
            @endif
        </div>
    </div>
</div>

<div class="card p-4 rounded-xl">
    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
        <div class="md:max-w-xl">
            <h2 class="text-lg font-semibold text-slate-900">Homepage Contact Details</h2>
            <p class="text-sm text-slate-500 mt-1">Edit the phone and WhatsApp details shown in the homepage header, hero, and footer.</p>
        </div>
        <form action="{{ route('admin.home-page-content.contact.update') }}" method="POST" class="w-full md:max-w-2xl grid md:grid-cols-2 gap-3">
            @csrf
            <div>
                <label class="text-sm font-semibold text-slate-800">Support Label</label>
                <input type="text" name="support_label" value="{{ old('support_label', $contactSettings['support_label']) }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-800">Display Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $contactSettings['phone']) }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-800">WhatsApp Number</label>
                <input type="text" name="whatsapp_phone" value="{{ old('whatsapp_phone', $contactSettings['whatsapp_phone']) }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2" placeholder="254700000000">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-800">WhatsApp Message</label>
                <input type="text" name="whatsapp_message" value="{{ old('whatsapp_message', $contactSettings['whatsapp_message']) }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-800">Email</label>
                <input type="email" name="email" value="{{ old('email', $contactSettings['email']) }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-800">Address</label>
                <input type="text" name="address" value="{{ old('address', $contactSettings['address']) }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2">
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="px-5 py-2 rounded bg-sky-600 text-white font-semibold hover:bg-sky-500">Save Contact Details</button>
            </div>
        </form>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-4">
    <div class="card p-4">
        <h2 class="text-lg font-semibold mb-3">{{ isset($editingCategory) && $editingCategory ? 'Edit Work Category' : 'Add Work Category' }}</h2>
        <form action="{{ isset($editingCategory) && $editingCategory ? route('admin.work-categories.update', $editingCategory) : route('admin.work-categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
            @csrf
            @if(isset($editingCategory) && $editingCategory)
                @method('PUT')
            @endif
            <div>
                <label class="text-sm font-semibold text-slate-800">Category Name</label>
                <input type="text" name="name" value="{{ old('name', $editingCategory->name ?? '') }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2" required>
            </div>
            <div class="grid md:grid-cols-2 gap-3">
                <div>
                    <label class="text-sm font-semibold text-slate-800">Number of Items</label>
                    <input type="number" min="0" name="item_count" value="{{ old('item_count', $editingCategory->item_count ?? 0) }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2">
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Sort Order</label>
                    <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $editingCategory->sort_order ?? 0) }}" class="w-full bg-white border border-slate-200 rounded px-3 py-2">
                </div>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" class="accent-sky-600" {{ old('is_active', $editingCategory->is_active ?? true) ? 'checked' : '' }}>
                <span class="text-sm text-slate-700">Show on homepage</span>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-800">Category Image {{ isset($editingCategory) && $editingCategory ? '(leave blank to keep current)' : '' }}</label>
                <input type="file" name="image" accept="image/*" class="w-full bg-white border border-slate-200 rounded px-3 py-2" {{ isset($editingCategory) && $editingCategory ? '' : 'required' }}>
                @if(isset($editingCategory) && $editingCategory && $editingCategory->image_url)
                    <div class="mt-2">
                        <img src="{{ $editingCategory->image_url }}" alt="" class="h-20 w-20 rounded-full border border-slate-200 object-cover">
                    </div>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <button class="px-5 py-2 rounded bg-sky-600 text-white font-semibold hover:bg-sky-500" type="submit">
                    {{ isset($editingCategory) && $editingCategory ? 'Update Category' : 'Add Category' }}
                </button>
                @if(isset($editingCategory) && $editingCategory)
                    <a href="{{ route('admin.home-page-content.index') }}" class="text-sm text-slate-600 hover:text-slate-900">Cancel edit</a>
                @endif
            </div>
        </form>
    </div>

    <div class="card p-4">
        <h2 class="text-lg font-semibold mb-3">Current Work Categories</h2>
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
                        <a href="{{ route('admin.home-page-content.index', ['edit' => $category->id]) }}" class="text-sky-600 font-semibold text-sm">Edit</a>
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
