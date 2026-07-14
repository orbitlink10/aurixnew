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
        $query = Product::query()->orderByDesc('created_at');

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
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        $data['google_merchant'] = $request->boolean('google_merchant');
        $data['quantity'] = $data['quantity'] ?? 0;
        if (! empty($data['product_category_id'])) {
            $data['category_name'] = ProductCategory::find($data['product_category_id'])?->name;
        }

        $image = $request->file('photo') ?: $request->file('image');
        if ($image) {
            $data['image_path'] = $image->store('products', 'uploads');
        }
        unset($data['photo'], $data['image']);

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function show(Product $product)
    {
        return redirect()->route('admin.products.edit', $product);
    }

    public function edit(Product $product)
    {
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
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        $data['google_merchant'] = $request->boolean('google_merchant');
        $data['quantity'] = $data['quantity'] ?? 0;
        if (! empty($data['product_category_id'])) {
            $data['category_name'] = ProductCategory::find($data['product_category_id'])?->name;
        }

        $image = $request->file('photo') ?: $request->file('image');
        if ($image) {
            if ($product->image_path) {
                Storage::disk('uploads')->delete($product->image_path);
                Storage::disk('public')->delete($product->image_path); // legacy clean-up
            }
            $data['image_path'] = $image->store('products', 'uploads');
        }
        unset($data['photo'], $data['image']);

        $product->update($data);
        $this->syncPricesForMatchingProducts($product);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    private function syncPricesForMatchingProducts(Product $product): void
    {
        $comparableName = Product::comparableName($product->name);

        if ($comparableName === '') {
            return;
        }

        Product::query()
            ->whereKeyNot($product->id)
            ->get(['id', 'name'])
            ->filter(fn (Product $matchingProduct) => Product::comparableName($matchingProduct->name) === $comparableName)
            ->each(fn (Product $matchingProduct) => $matchingProduct->update([
                'price' => $product->price,
                'marked_price' => $product->marked_price,
            ]));
    }

    public function destroy(Product $product)
    {
        if ($product->image_path) {
            Storage::disk('uploads')->delete($product->image_path);
            Storage::disk('public')->delete($product->image_path); // legacy clean-up
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product removed.');
    }
}
