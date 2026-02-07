@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-4">
    <div class="card p-4 rounded-xl">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-semibold text-slate-900">{{ isset($editing) ? 'Edit User' : 'Add User' }}</h2>
            @isset($editing)
                <a href="{{ route('admin.users.index') }}" class="text-sky-600 text-sm">Cancel edit</a>
            @endisset
        </div>
        @php
            $selectedRoles = collect(old('roles', isset($editing) ? $editing->roles->pluck('id')->toArray() : []))->map(fn ($id) => (int) $id);
        @endphp
        <form method="POST" action="{{ isset($editing) ? route('admin.users.update', $editing) : route('admin.users.store') }}" class="grid md:grid-cols-2 gap-4">
            @csrf
            @isset($editing)
                @method('PUT')
            @endisset
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $editing->name ?? '') }}" required class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900">
            </div>
            <div>
                <label class="block text-sm mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $editing->email ?? '') }}" required class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">{{ isset($editing) ? 'Password (leave blank to keep current)' : 'Password' }}</label>
                <input type="password" name="password" {{ isset($editing) ? '' : 'required' }} class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-2">Roles</label>
                <div class="grid md:grid-cols-3 gap-2">
                    @forelse ($roles as $role)
                        <label class="inline-flex items-center gap-2 text-sm bg-slate-50 border border-slate-200 rounded px-3 py-2">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="accent-sky-600" {{ $selectedRoles->contains($role->id) ? 'checked' : '' }}>
                            <span>{{ $role->name }}</span>
                        </label>
                    @empty
                        <p class="text-slate-500 text-sm">No roles found.</p>
                    @endforelse
                </div>
            </div>
            <div class="md:col-span-2">
                <button class="bg-sky-600 hover:bg-sky-500 text-white font-semibold px-4 py-2 rounded">{{ isset($editing) ? 'Update User' : 'Create User' }}</button>
            </div>
        </form>
    </div>

    <div class="card p-4 rounded-xl">
        <h2 class="text-lg font-semibold text-slate-900 mb-3">Users</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-slate-500">
                    <tr>
                        <th class="text-left py-2">Name</th>
                        <th class="text-left py-2">Email</th>
                        <th class="text-left py-2">Roles</th>
                        <th class="text-left py-2">Created</th>
                        <th class="text-right py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-t border-slate-200">
                            <td class="py-2 font-semibold text-slate-900">{{ $user->name }}</td>
                            <td class="py-2 text-slate-700">{{ $user->email }}</td>
                            <td class="py-2">
                                <div class="flex flex-wrap gap-1">
                                    @forelse ($user->roles as $role)
                                        <span class="px-2 py-1 rounded bg-sky-50 text-sky-700 text-xs">{{ $role->name }}</span>
                                    @empty
                                        <span class="text-slate-500 text-xs">No role</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="py-2 text-slate-700">{{ $user->created_at?->format('Y-m-d') }}</td>
                            <td class="py-2 text-right space-x-3">
                                <a class="text-sky-600 font-semibold" href="{{ route('admin.users.edit', $user) }}">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-rose-500" onclick="return confirm('Delete this user?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="py-3 text-slate-500" colspan="5">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $users->links() }}</div>
    </div>
</div>
@endsection
