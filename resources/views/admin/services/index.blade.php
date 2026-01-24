@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-4">
    <div class="card p-4 rounded-xl">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-semibold text-white">{{ isset($editing) ? 'Edit Service' : 'Add Service' }}</h2>
            @isset($editing)
                <a href="{{ route('admin.services.index') }}" class="text-sky-400 text-sm">Cancel edit</a>
            @endisset
        </div>
        <form method="POST" action="{{ isset($editing) ? route('admin.services.update', $editing) : route('admin.services.store') }}" class="grid md:grid-cols-2 gap-4">
            @csrf
            @isset($editing)
                @method('PUT')
            @endisset
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $editing->name ?? '') }}" required class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $editing->slug ?? '') }}" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm mb-1">Base Price</label>
                <input type="number" step="0.01" name="base_price" value="{{ old('base_price', $editing->base_price ?? 0) }}" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            </div>
            <div class="flex items-center gap-2 pt-6">
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_active" value="1" class="accent-sky-500" {{ old('is_active', $editing->is_active ?? true) ? 'checked' : '' }}>
                    Active
                </label>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">{{ old('description', $editing->description ?? '') }}</textarea>
            </div>
            <div class="md:col-span-2">
                <button class="bg-sky-500 hover:bg-sky-400 text-slate-900 font-semibold px-4 py-2 rounded">{{ isset($editing) ? 'Update' : 'Create' }}</button>
            </div>
        </form>
    </div>

    <div class="card p-4 rounded-xl">
        <h2 class="text-lg font-semibold text-white mb-3">Services</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-slate-400">
                    <tr>
                        <th class="text-left py-2">Name</th>
                        <th class="text-left py-2">Slug</th>
                        <th class="text-left py-2">Base Price</th>
                        <th class="text-left py-2">Active</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                        <tr class="border-t border-slate-800">
                            <td class="py-2 font-semibold">{{ $service->name }}</td>
                            <td class="py-2 text-slate-400">{{ $service->slug }}</td>
                            <td class="py-2">${{ number_format($service->base_price, 2) }}</td>
                            <td class="py-2">{{ $service->is_active ? 'Yes' : 'No' }}</td>
                            <td class="py-2 text-right space-x-2">
                                <a class="text-sky-400" href="{{ route('admin.services.edit', $service) }}">Edit</a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-rose-300" onclick="return confirm('Delete this service?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="py-3 text-slate-500" colspan="5">No services created.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $services->links() }}</div>
    </div>
</div>
@endsection
