<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::query()
            ->with(['category', 'images'])
            ->orderByDesc('created_at');

        if ($search = request('query')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', '%'.$search.'%')
                    ->orWhere('slug', 'like', '%'.$search.'%')
                    ->orWhere('category_name', 'like', '%'.$search.'%');
            });
        }

        $products = $query->paginate(15)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.form', [
            'product' => new Product(),
            'categories' => ProductCategory::with('children')->parents()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'marked_price' => ['nullable', 'numeric', 'min:0'],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'product_category_id' => ['nullable', 'exists:product_categories,id'],
            'category_name' => ['nullable', 'string', 'max:255'],
            'subcategory_name' => ['nullable', 'string', 'max:255'],
            'google_merchant' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:5120'],
            'photo' => ['nullable', 'image', 'max:5120'],
            'images' => ['nullable', 'array', 'max:12'],
            'images.*' => ['image', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        $data['google_merchant'] = $request->boolean('google_merchant');
        $data['quantity'] = $data['quantity'] ?? 0;
        if (! empty($data['product_category_id'])) {
            $data['category_name'] = ProductCategory::find($data['product_category_id'])?->name;
        }

        $uploads = $this->uploadedProductImages($request);
        unset($data['photo'], $data['image'], $data['images']);

        $product = Product::create($data);
        $this->storeProductImages($product, $uploads);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function show(Product $product)
    {
        return redirect()->route('admin.products.edit', $product);
    }

    public function edit(Product $product)
    {
        $product->load('images');

        return view('admin.products.form', [
            'product' => $product,
            'categories' => ProductCategory::with('children')->parents()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,'.$product->id],
            'description' => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'marked_price' => ['nullable', 'numeric', 'min:0'],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'product_category_id' => ['nullable', 'exists:product_categories,id'],
            'category_name' => ['nullable', 'string', 'max:255'],
            'subcategory_name' => ['nullable', 'string', 'max:255'],
            'google_merchant' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:5120'],
            'photo' => ['nullable', 'image', 'max:5120'],
            'images' => ['nullable', 'array', 'max:12'],
            'images.*' => ['image', 'max:5120'],
            'remove_primary_image' => ['nullable', 'boolean'],
            'remove_product_images' => ['nullable', 'array'],
            'remove_product_images.*' => ['integer', 'exists:product_images,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        $data['google_merchant'] = $request->boolean('google_merchant');
        $data['quantity'] = $data['quantity'] ?? 0;
        if (! empty($data['product_category_id'])) {
            $data['category_name'] = ProductCategory::find($data['product_category_id'])?->name;
        }

        if ($request->boolean('remove_primary_image') && $product->image_path) {
            $this->deleteStoredImage($product->image_path);
            $data['image_path'] = null;
        }

        $this->deleteProductImages($product, $request->input('remove_product_images', []));

        $uploads = $this->uploadedProductImages($request);
        unset($data['photo'], $data['image'], $data['images'], $data['remove_primary_image'], $data['remove_product_images']);

        $product->update($data);
        $product->refresh();
        $this->storeProductImages($product, $uploads);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        collect([$product->image_path])
            ->merge($product->images()->pluck('image_path'))
            ->filter()
            ->unique()
            ->each(fn (string $path) => $this->deleteStoredImage($path));

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product removed.');
    }

    private function uploadedProductImages(Request $request): array
    {
        $uploads = array_values(array_filter((array) $request->file('images', [])));

        if (! $uploads) {
            foreach (['photo', 'image'] as $field) {
                if ($request->hasFile($field)) {
                    $uploads[] = $request->file($field);
                }
            }
        }

        return $uploads;
    }

    private function storeProductImages(Product $product, array $uploads): void
    {
        if (! $uploads) {
            return;
        }

        $nextSortOrder = ((int) $product->images()->max('sort_order')) + 1;

        foreach ($uploads as $upload) {
            $path = $upload->store('products', 'uploads');

            if (! $product->image_path) {
                $product->forceFill(['image_path' => $path])->save();
                continue;
            }

            $product->images()->create([
                'image_path' => $path,
                'sort_order' => $nextSortOrder++,
            ]);
        }
    }

    private function deleteProductImages(Product $product, array $imageIds): void
    {
        $ids = collect($imageIds)
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->values();

        if ($ids->isEmpty()) {
            return;
        }

        $product->images()
            ->whereIn('id', $ids)
            ->get()
            ->each(function ($image) {
                $this->deleteStoredImage($image->image_path);
                $image->delete();
            });
    }

    private function deleteStoredImage(?string $path): void
    {
        if (! $path) {
            return;
        }

        Storage::disk('uploads')->delete($path);
        Storage::disk('public')->delete($path);
    }
}
