<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage_blogs');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = BlogPost::with(['category', 'tags'])->orderByDesc('created_at')->paginate(15);

        return view('admin.blog.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.form', [
            'categories' => BlogCategory::orderBy('name')->get(),
            'tags' => BlogTag::orderBy('name')->get(),
            'post' => new BlogPost(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:blog_posts,slug'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:300'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['required', 'string'],
            'status' => ['required', 'string', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
            'category_id' => ['nullable', 'exists:blog_categories,id'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['exists:blog_tags,id'],
            'cover_image' => ['nullable', 'string', 'max:255'],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']).'-'.Str::random(4);
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $post = BlogPost::create(array_merge($data, ['user_id' => auth()->id()]));
        $post->tags()->sync($data['tag_ids'] ?? []);

        return redirect()->route('admin.blog-posts.index')->with('success', 'Post created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $blogPost)
    {
        return redirect()->route('admin.blog-posts.edit', $blogPost);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $blogPost)
    {
        return view('admin.blog.form', [
            'post' => $blogPost->load('tags'),
            'categories' => BlogCategory::orderBy('name')->get(),
            'tags' => BlogTag::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogPost $blogPost)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:blog_posts,slug,'.$blogPost->id],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:300'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['required', 'string'],
            'status' => ['required', 'string', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
            'category_id' => ['nullable', 'exists:blog_categories,id'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['exists:blog_tags,id'],
            'cover_image' => ['nullable', 'string', 'max:255'],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']).'-'.Str::random(4);
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $blogPost->update($data);
        $blogPost->tags()->sync($data['tag_ids'] ?? []);

        return redirect()->route('admin.blog-posts.index')->with('success', 'Post updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();

        return back()->with('success', 'Post deleted.');
    }
}
