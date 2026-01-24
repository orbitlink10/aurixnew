@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-4">
    <div class="card p-4 rounded-xl">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-semibold text-white">{{ isset($editing) ? 'Edit Package' : 'Add Package' }}</h2>
            @isset($editing)
                <a href="{{ route('admin.packages.index') }}" class="text-sky-400 text-sm">Cancel edit</a>
            @endisset
        </div>
        <form method="POST" action="{{ isset($editing) ? route('admin.packages.update', $editing) : route('admin.packages.store') }}" class="grid md:grid-cols-2 gap-4">
            @csrf
            @isset($editing)
                @method('PUT')
            @endisset
            <div>
                <label class="block text-sm mb-1">Service</label>
                <select name="service_id" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
                    <option value="">Standalone</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" @selected(old('service_id', $editing->service_id ?? '') == $service->id)>{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $editing->name ?? '') }}" required class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $editing->slug ?? '') }}" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm mb-1">Billing Cycle</label>
                <select name="billing_cycle" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
                    @foreach (['one-time','monthly','yearly'] as $cycle)
                        <option value="{{ $cycle }}" @selected(old('billing_cycle', $editing->billing_cycle ?? 'one-time') == $cycle)>{{ ucfirst(str_replace('-',' ',$cycle)) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">Price</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $editing->price ?? 0) }}" required class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            </div>
            <div class="flex items-center gap-4 pt-6">
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_active" value="1" class="accent-sky-500" {{ old('is_active', $editing->is_active ?? true) ? 'checked' : '' }}>
                    Active
                </label>
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_featured" value="1" class="accent-sky-500" {{ old('is_featured', $editing->is_featured ?? false) ? 'checked' : '' }}>
                    Featured
                </label>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">Description</label>
                <textarea name="description" rows="2" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">{{ old('description', $editing->description ?? '') }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">Features (one per line)</label>
                <textarea name="features_text" rows="3" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">{{ old('features_text', isset($editing) ? implode("\n", $editing->features ?? []) : '') }}</textarea>
            </div>
            <div class="md:col-span-2">
                <button class="bg-sky-500 hover:bg-sky-400 text-slate-900 font-semibold px-4 py-2 rounded">{{ isset($editing) ? 'Update' : 'Create' }}</button>
            </div>
        </form>
    </div>

    <div class="card p-4 rounded-xl">
        <h2 class="text-lg font-semibold text-white mb-3">Packages</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-slate-400">
                    <tr>
                        <th class="text-left py-2">Name</th>
                        <th class="text-left py-2">Service</th>
                        <th class="text-left py-2">Billing</th>
                        <th class="text-left py-2">Price</th>
                        <th class="text-left py-2">Featured</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($packages as $package)
                        <tr class="border-t border-slate-800">
                            <td class="py-2 font-semibold">{{ $package->name }}</td>
                            <td class="py-2 text-slate-400">{{ $package->service->name ?? '—' }}</td>
                            <td class="py-2">{{ ucfirst(str_replace('_',' ',$package->billing_cycle)) }}</td>
                            <td class="py-2">${{ number_format($package->price, 2) }}</td>
                            <td class="py-2">{{ $package->is_featured ? 'Yes' : 'No' }}</td>
                            <td class="py-2 text-right space-x-2">
                                <a class="text-sky-400" href="{{ route('admin.packages.edit', $package) }}">Edit</a>
                                <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-rose-300" onclick="return confirm('Delete this package?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="py-3 text-slate-500" colspan="6">No packages yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $packages->links() }}</div>
    </div>
</div>
@endsection
