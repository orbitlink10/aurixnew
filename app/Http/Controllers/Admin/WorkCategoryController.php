<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WorkCategoryController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.home-page-content.index');
    }

    public function create()
    {
        return redirect()->route('admin.home-page-content.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'item_count' => ['nullable', 'integer', 'min:0'],
            'image' => ['required', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $path = $request->file('image')->store('works', 'uploads');

        WorkCategory::create([
            'name' => $data['name'],
            'item_count' => $data['item_count'] ?? 0,
            'image_path' => $path,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.home-page-content.index')->with('success', 'Work category added.');
    }

    public function show(WorkCategory $workCategory)
    {
        return redirect()->route('admin.home-page-content.index', ['edit' => $workCategory->id]);
    }

    public function edit(WorkCategory $workCategory)
    {
        return redirect()->route('admin.home-page-content.index', ['edit' => $workCategory->id]);
    }

    public function update(Request $request, WorkCategory $workCategory)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'item_count' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($workCategory->image_path) {
                Storage::disk('uploads')->delete($workCategory->image_path);
                Storage::disk('public')->delete($workCategory->image_path); // legacy clean-up
            }
            $data['image_path'] = $request->file('image')->store('works', 'uploads');
        }

        $data['item_count'] = $data['item_count'] ?? 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active', true);

        $workCategory->update($data);

        return redirect()->route('admin.home-page-content.index')->with('success', 'Work category updated.');
    }

    public function destroy(WorkCategory $workCategory)
    {
        if ($workCategory->image_path) {
            Storage::disk('uploads')->delete($workCategory->image_path);
            Storage::disk('public')->delete($workCategory->image_path); // legacy clean-up
        }

        $workCategory->delete();

        return redirect()->route('admin.home-page-content.index')->with('success', 'Work category removed.');
    }
}
