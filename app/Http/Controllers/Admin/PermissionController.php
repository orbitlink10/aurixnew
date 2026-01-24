<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage_permissions');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::orderBy('name')->paginate(30);

        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.permissions.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:permissions,slug'],
            'description' => ['nullable', 'string'],
        ]);

        Permission::create([
            'name' => $data['name'],
            'slug' => $data['slug'] ?? Str::slug($data['name']),
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        return redirect()->route('admin.permissions.edit', $permission);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        $permissions = Permission::orderBy('name')->paginate(30);

        return view('admin.permissions.index', [
            'permissions' => $permissions,
            'editing' => $permission,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:permissions,slug,'.$permission->id],
            'description' => ['nullable', 'string'],
        ]);

        $permission->update([
            'name' => $data['name'],
            'slug' => $data['slug'] ?? Str::slug($data['name']),
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->roles()->detach();
        $permission->users()->detach();
        $permission->delete();

        return redirect()->route('admin.permissions.index')->with('success', 'Permission removed.');
    }
}
