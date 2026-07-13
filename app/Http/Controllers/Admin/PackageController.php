<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage_packages');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::with('service')->orderByDesc('created_at')->paginate(15);
        $services = Service::orderBy('name')->get();

        return view('admin.packages.index', compact('packages', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.packages.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => ['nullable', 'exists:services,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:packages,slug'],
            'description' => ['nullable', 'string'],
            'billing_cycle' => ['required', 'string', 'max:50'],
            'price' => ['required', 'numeric', 'min:0'],
            'features_text' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['features'] = collect(preg_split('/\r\n|\n/', (string) ($data['features_text'] ?? '')))
            ->filter()
            ->values()
            ->toArray();
        unset($data['features_text']);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        Package::create($data);

        return redirect()->route('admin.packages.index')->with('success', 'Package created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        return redirect()->route('admin.packages.edit', $package);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        $packages = Package::with('service')->orderByDesc('created_at')->paginate(15);
        $services = Service::orderBy('name')->get();

        return view('admin.packages.index', [
            'packages' => $packages,
            'services' => $services,
            'editing' => $package,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        $data = $request->validate([
            'service_id' => ['nullable', 'exists:services,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:packages,slug,'.$package->id],
            'description' => ['nullable', 'string'],
            'billing_cycle' => ['required', 'string', 'max:50'],
            'price' => ['required', 'numeric', 'min:0'],
            'features_text' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['features'] = collect(preg_split('/\r\n|\n/', (string) ($data['features_text'] ?? '')))
            ->filter()
            ->values()
            ->toArray();
        unset($data['features_text']);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        $package->update($data);

        return redirect()->route('admin.packages.index')->with('success', 'Package updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Package removed.');
    }
}
