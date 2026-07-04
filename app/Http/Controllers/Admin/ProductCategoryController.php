<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage_categories');
    }

    public function index()
    {
        $categories = ProductCategory::withCount('products')->orderBy('id')->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.form', [
            'category' => new ProductCategory(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'max:5120'],
        ]);

        $data['slug'] = $this->uniqueSlug($data['name']);

        if ($request->hasFile('photo')) {
            $data['image_path'] = $request->file('photo')->store('categories', 'uploads');
        }

        unset($data['photo']);

        ProductCategory::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function show(ProductCategory $category)
    {
        $products = Product::where('product_category_id', $category->id)
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('admin.categories.show', compact('category', 'products'));
    }

    public function edit(ProductCategory $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, ProductCategory $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'max:5120'],
        ]);

        if ($category->name !== $data['name']) {
            $data['slug'] = $this->uniqueSlug($data['name'], $category->id);
        }

        if ($request->hasFile('photo')) {
            if ($category->image_path) {
                Storage::disk('uploads')->delete($category->image_path);
                Storage::disk('public')->delete($category->image_path);
            }
            $data['image_path'] = $request->file('photo')->store('categories', 'uploads');
        }

        unset($data['photo']);

        $category->update($data);

        Product::where('product_category_id', $category->id)->update([
            'category_name' => $category->name,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(ProductCategory $category)
    {
        if ($category->image_path) {
            Storage::disk('uploads')->delete($category->image_path);
            Storage::disk('public')->delete($category->image_path);
        }

        Product::where('product_category_id', $category->id)->update([
            'product_category_id' => null,
            'category_name' => null,
        ]);

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $counter = 2;

        while (ProductCategory::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
