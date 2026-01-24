<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage_categories');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = BlogCategory::orderBy('name')->paginate(20);

        return view('admin.blog.categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.blog-categories.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:blog_categories,slug'],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        BlogCategory::create($data);

        return back()->with('success', 'Category created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogCategory $blogCategory)
    {
        return redirect()->route('admin.blog-categories.edit', $blogCategory);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $blogCategory)
    {
        $categories = BlogCategory::orderBy('name')->paginate(20);

        return view('admin.blog.categories', [
            'categories' => $categories,
            'editing' => $blogCategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogCategory $blogCategory)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:blog_categories,slug,'.$blogCategory->id],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        $blogCategory->update($data);

        return redirect()->route('admin.blog-categories.index')->with('success', 'Category updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();

        return back()->with('success', 'Category removed.');
    }
}
