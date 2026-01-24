@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-4">
    <div class="card p-4 rounded-xl">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-semibold text-white">{{ isset($editing) ? 'Edit Lead' : 'New Lead' }}</h2>
            @isset($editing)
                <a href="{{ route('admin.leads.index') }}" class="text-sky-400 text-sm">Cancel edit</a>
            @endisset
        </div>
        <form method="POST" action="{{ isset($editing) ? route('admin.leads.update', $editing) : route('admin.leads.store') }}" class="grid md:grid-cols-2 gap-4">
            @csrf
            @isset($editing)
                @method('PUT')
            @endisset
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $editing->name ?? '') }}" required class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $editing->email ?? '') }}" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm mb-1">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $editing->phone ?? '') }}" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm mb-1">Interested Service</label>
                <select name="service_id" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
                    <option value="">--</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" @selected(old('service_id', $editing->service_id ?? '') == $service->id)>{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">Budget</label>
                <input type="number" step="0.01" name="budget" value="{{ old('budget', $editing->budget ?? '') }}" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm mb-1">Status</label>
                <select name="status" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
                    @foreach (['new','contacted','quoted','won','lost'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $editing->status ?? 'new') == $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">Assign to</label>
                <select name="assigned_to" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
                    <option value="">--</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected(old('assigned_to', $editing->assigned_to ?? '') == $user->id)>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">Notes</label>
                <textarea name="description" rows="3" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">{{ old('description', $editing->description ?? '') }}</textarea>
            </div>
            <div class="md:col-span-2">
                <button class="bg-sky-500 hover:bg-sky-400 text-slate-900 font-semibold px-4 py-2 rounded">{{ isset($editing) ? 'Update' : 'Create' }}</button>
            </div>
        </form>
    </div>

    <div class="card p-4 rounded-xl">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-semibold text-white">Leads</h2>
            <form method="GET" class="text-sm flex items-center gap-2">
                <select name="status" class="bg-slate-800 border border-slate-700 rounded px-2 py-1 text-white">
                    <option value="">All</option>
                    @foreach (['new','contacted','quoted','won','lost'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button class="px-3 py-1 bg-slate-800 border border-slate-700 rounded">Filter</button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-slate-400">
                    <tr>
                        <th class="text-left py-2">Name</th>
                        <th class="text-left py-2">Service</th>
                        <th class="text-left py-2">Status</th>
                        <th class="text-left py-2">Budget</th>
                        <th class="text-left py-2">Assigned</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($leads as $lead)
                        <tr class="border-t border-slate-800">
                            <td class="py-2">
                                <div class="font-semibold">{{ $lead->name }}</div>
                                <div class="text-slate-400">{{ $lead->email }}</div>
                            </td>
                            <td class="py-2 text-slate-400">{{ $lead->service->name ?? '—' }}</td>
                            <td class="py-2 capitalize">{{ $lead->status }}</td>
                            <td class="py-2">{{ $lead->budget ? '$'.number_format($lead->budget, 2) : '—' }}</td>
                            <td class="py-2 text-slate-400">{{ $lead->assignee->name ?? '—' }}</td>
                            <td class="py-2 text-right space-x-2">
                                <a class="text-sky-400" href="{{ route('admin.leads.edit', $lead) }}">Edit</a>
                                <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-rose-300" onclick="return confirm('Delete this lead?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="py-3 text-slate-500" colspan="6">No leads yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $leads->links() }}</div>
    </div>
</div>
@endsection
