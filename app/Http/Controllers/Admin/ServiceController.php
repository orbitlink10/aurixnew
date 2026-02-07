<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage_services');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::orderByDesc('created_at')->paginate(15);

        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.services.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:services,slug'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'base_price' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('services', 'uploads');
        }

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return redirect()->route('admin.services.edit', $service);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $services = Service::orderByDesc('created_at')->paginate(15);

        return view('admin.services.index', [
            'services' => $services,
            'editing' => $service,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:services,slug,'.$service->id],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'base_price' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            if ($service->image_path) {
                Storage::disk('uploads')->delete($service->image_path);
                Storage::disk('public')->delete($service->image_path); // legacy clean-up
            }
            $data['image_path'] = $request->file('image')->store('services', 'uploads');
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Service updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        if ($service->image_path) {
            Storage::disk('uploads')->delete($service->image_path);
            Storage::disk('public')->delete($service->image_path); // legacy clean-up
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service removed.');
    }
}
