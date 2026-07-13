<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogTagController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage_tags');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = BlogTag::orderBy('name')->paginate(20);

        return view('admin.blog.tags', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.blog-tags.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:blog_tags,slug'],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        BlogTag::create($data);

        return back()->with('success', 'Tag created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogTag $blogTag)
    {
        return redirect()->route('admin.blog-tags.edit', $blogTag);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogTag $blogTag)
    {
        $tags = BlogTag::orderBy('name')->paginate(20);

        return view('admin.blog.tags', [
            'tags' => $tags,
            'editing' => $blogTag,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogTag $blogTag)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:blog_tags,slug,'.$blogTag->id],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        $blogTag->update($data);

        return redirect()->route('admin.blog-tags.index')->with('success', 'Tag updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogTag $blogTag)
    {
        $blogTag->delete();

        return back()->with('success', 'Tag removed.');
    }
}
