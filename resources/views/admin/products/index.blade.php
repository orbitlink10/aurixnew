@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-4">
    <div class="card p-4 rounded-xl">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-semibold text-white">{{ isset($editing) ? 'Edit Product' : 'Add Product' }}</h2>
            @isset($editing)
                <a href="{{ route('admin.products.index') }}" class="text-sky-400 text-sm">Cancel edit</a>
            @endisset
        </div>
        <form method="POST" enctype="multipart/form-data" action="{{ isset($editing) ? route('admin.products.update', $editing) : route('admin.products.store') }}" class="grid md:grid-cols-2 gap-4">
            @csrf
            @isset($editing)
                @method('PUT')
            @endisset
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $editing->name ?? '') }}" required class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900 placeholder:text-slate-400">
            </div>
            <div>
                <label class="block text-sm mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $editing->slug ?? '') }}" class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900 placeholder:text-slate-400">
            </div>
            <div>
                <label class="block text-sm mb-1">Price</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $editing->price ?? 0) }}" class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900">
            </div>
            <div class="flex items-center gap-2 pt-6">
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_active" value="1" class="accent-sky-500" {{ old('is_active', $editing->is_active ?? true) ? 'checked' : '' }}>
                    Active
                </label>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900 placeholder:text-slate-400">{{ old('description', $editing->description ?? '') }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">Product Image {{ isset($editing) ? '(leave blank to keep current)' : '' }}</label>
                <input type="file" name="image" accept="image/*" class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900 file:mr-3 file:rounded file:border-0 file:bg-slate-100 file:px-3 file:py-1 file:text-slate-800">
                @if(isset($editing) && $editing->image_url)
                    <div class="mt-2">
                        <img src="{{ $editing->image_url }}" alt="" class="h-14 w-14 rounded object-cover border border-slate-700">
                    </div>
                @endif
            </div>
            <div class="md:col-span-2">
                <button class="bg-sky-500 hover:bg-sky-400 text-slate-900 font-semibold px-4 py-2 rounded">{{ isset($editing) ? 'Update' : 'Create' }}</button>
            </div>
        </form>
    </div>

    <div class="card p-4 rounded-xl">
        <h2 class="text-lg font-semibold text-white mb-3">Products</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-slate-400">
                    <tr>
                        <th class="text-left py-2">Image</th>
                        <th class="text-left py-2">Name</th>
                        <th class="text-left py-2">Slug</th>
                        <th class="text-left py-2">Price</th>
                        <th class="text-left py-2">Active</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr class="border-t border-slate-800">
                            <td class="py-2">
                                @if($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="" class="h-10 w-10 rounded object-cover border border-slate-700">
                                @else
                                    <div class="h-10 w-10 rounded bg-slate-800 border border-slate-700"></div>
                                @endif
                            </td>
                            <td class="py-2 font-semibold">{{ $product->name }}</td>
                            <td class="py-2 text-slate-400">{{ $product->slug }}</td>
                            <td class="py-2">${{ number_format($product->price, 2) }}</td>
                            <td class="py-2">{{ $product->is_active ? 'Yes' : 'No' }}</td>
                            <td class="py-2 text-right space-x-2">
                                <a class="text-sky-400" href="{{ route('admin.products.edit', $product) }}">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-rose-300" onclick="return confirm('Delete this product?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="py-3 text-slate-500" colspan="6">No products created.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $products->links() }}</div>
    </div>
</div>
@endsection
