<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderMessageController;
use App\Http\Controllers\Admin\OrderFileController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogTagController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\HomeHeroImageController;
use App\Http\Controllers\Admin\SiteLogoController;
use App\Http\Controllers\Admin\WorkCategoryController;
use App\Http\Controllers\Admin\HomePageContentController;
use App\Models\SliderImage;
use App\Models\BlogPost;
use App\Models\SiteSetting;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\WorkCategory;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    $logoUrl = Schema::hasTable('site_settings')
        ? SiteSetting::logoUrl()
        : null;

    $contactSettings = Schema::hasTable('site_settings')
        ? SiteSetting::contactSettings()
        : SiteSetting::defaultContactSettings();

    $heroImageUrls = Schema::hasTable('site_settings')
        ? SiteSetting::heroImageUrls()
        : [];

    $heroImage = $heroImageUrls[0] ?? null;

    $heroVideoEmbedUrl = Schema::hasTable('site_settings')
        ? SiteSetting::heroVideoEmbedUrl()
        : null;

    // Featured branding categories — only those with active, published products.
    $homepageCategories = collect();

    if (Schema::hasTable('product_categories')) {
        $homepageCategories = ProductCategory::query()
            ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
            ->when(
                Schema::hasColumn('product_categories', 'show_in_menu'),
                fn ($q) => $q->where('show_in_menu', true)
            )
            ->when(
                Schema::hasColumn('product_categories', 'menu_sort_order'),
                fn ($q) => $q->orderBy('menu_sort_order')
            )
            ->orderBy('name')
            ->get()
            ->filter(fn ($category) => $category->products_count > 0)
            ->take(6)
            ->values();
    }

    // Portfolio / recent work — admin managed "work categories".
    $portfolio = collect();

    if (Schema::hasTable('work_categories')) {
        $portfolio = WorkCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();
    }

    // A small selection of featured products (no pricing shown publicly).
    $homepageProducts = collect();
    if (Schema::hasTable('products')) {
        $homepageProducts = Product::query()
            ->where('is_active', true)
            ->with('category')
            ->orderByDesc('updated_at')
            ->take(4)
            ->get();
    }

    return view('welcome', compact('logoUrl', 'contactSettings', 'heroImage', 'heroImageUrls', 'heroVideoEmbedUrl', 'homepageCategories', 'portfolio', 'homepageProducts'));
});

Route::get('/embroidery', function () {
    $contactSettings = Schema::hasTable('site_settings')
        ? SiteSetting::contactSettings()
        : SiteSetting::defaultContactSettings();

    $logoUrl = Schema::hasTable('site_settings')
        ? SiteSetting::logoUrl()
        : null;

    return view('embroidery', compact('contactSettings', 'logoUrl'));
})->name('public.embroidery');

Route::get('/embroidery/request-quote', function () {
    $contactSettings = Schema::hasTable('site_settings')
        ? SiteSetting::contactSettings()
        : SiteSetting::defaultContactSettings();

    $logoUrl = Schema::hasTable('site_settings')
        ? SiteSetting::logoUrl()
        : null;

    return view('embroidery-quote', compact('contactSettings', 'logoUrl'));
})->name('public.embroidery.quote');

Route::post('/embroidery/request-quote', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:120'],
        'email' => ['nullable', 'email', 'max:160'],
        'phone' => ['nullable', 'string', 'max:60'],
        'subject' => ['nullable', 'string', 'max:160'],
        'message' => ['required', 'string', 'max:5000'],
    ]);

    $to = 'info@aurixbranding.co.ke';
    $subject = $validated['subject'] ?: 'Embroidery quote request';
    $body = implode("\n", [
        'New Aurix Branding quote request',
        '',
        'Full name: '.$validated['name'],
        'Email: '.($validated['email'] ?: 'Not provided'),
        'Phone: '.($validated['phone'] ?: 'Not provided'),
        'Subject: '.$subject,
        '',
        'Message:',
        $validated['message'],
    ]);

    try {
        Mail::raw($body, function ($message) use ($to, $subject, $validated) {
            $message->to($to)->subject($subject);

            if (! empty($validated['email'])) {
                $message->replyTo($validated['email'], $validated['name']);
            }
        });
    } catch (\Throwable $exception) {
        report($exception);

        return back()
            ->withInput()
            ->with('quote_error', 'We could not send the email automatically. Please email info@aurixbranding.co.ke or WhatsApp +254 700816670.');
    }

    return back()->with('quote_success', 'Thank you. Your quote request has been sent to info@aurixbranding.co.ke.');
})->name('public.embroidery.quote.send');

Route::get('/create-design', function () {
    $logoUrl = Schema::hasTable('site_settings')
        ? SiteSetting::logoUrl()
        : null;

    return view('create-design', compact('logoUrl'));
})->name('public.create-design');

Route::any('/blog/{probe}', function () {
    abort(404);
})->where('probe', '.*\.php');

Route::get('/blog/{slug}', function (string $slug) {
    $post = BlogPost::where('slug', $slug)->where('status', 'published')->firstOrFail();
    $wordCount = str_word_count(strip_tags($post->body ?? ''));
    $readingTime = max(1, (int) ceil($wordCount / 200));
    $contactSettings = Schema::hasTable('site_settings')
        ? SiteSetting::contactSettings()
        : SiteSetting::defaultContactSettings();

    return view('blog.show', compact('post', 'readingTime', 'contactSettings'));
})->name('public.blog.show');

// Backward compatibility for old URLs
Route::get('/blog-posts/{slug}', function (string $slug) {
    return redirect()->route('public.blog.show', ['slug' => $slug], 301);
});

Route::get('/products', function () {
    $logoUrl = Schema::hasTable('site_settings')
        ? SiteSetting::logoUrl()
        : null;
    $contactSettings = Schema::hasTable('site_settings')
        ? SiteSetting::contactSettings()
        : SiteSetting::defaultContactSettings();

    if (! Schema::hasTable('products')) {
        $products = new LengthAwarePaginator([], 0, 12);
        $categories = collect();

        return view('products.index', compact('products', 'categories', 'logoUrl', 'contactSettings'));
    }

    $legacyBrand = 'Nai'.' Prints';

    $query = Product::query()
        ->where('is_active', true)
        ->with('category')
        ->where(function ($products) use ($legacyBrand) {
            $products->whereNull('category_name')
                ->orWhere('category_name', 'not like', '%'.$legacyBrand.'%');
        })
        ->where('name', 'not like', '%'.$legacyBrand.'%');

    $search = trim((string) request('q', ''));
    if ($search !== '') {
        $query->where(function ($products) use ($search) {
            $products->where('name', 'like', '%'.$search.'%')
                ->orWhere('slug', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')
                ->orWhere('category_name', 'like', '%'.$search.'%')
                ->orWhere('subcategory_name', 'like', '%'.$search.'%');
        });
    }

    if (request()->filled('category')) {
        $categoryValue = request('category');
        $category = Schema::hasTable('product_categories')
            ? ProductCategory::where('slug', $categoryValue)->first()
            : null;

        if ($category) {
            $query->whereIn('product_category_id', array_merge([$category->id], $category->descendantIds()));
        } elseif (! in_array(strtolower($categoryValue), ['all', 'all-categories'], true)) {
            $categoryName = str_replace('-', ' ', $categoryValue);
            $query->where(function ($products) use ($categoryName) {
                $products->where('category_name', 'like', '%'.$categoryName.'%')
                    ->orWhere('subcategory_name', 'like', '%'.$categoryName.'%')
                    ->orWhere('name', 'like', '%'.$categoryName.'%');
            });
        }
    }

    match (request('sort', 'newest')) {
        'name' => $query->orderBy('name'),
        'popular' => $query->orderByDesc('updated_at'),
        default => $query->orderByDesc('created_at'),
    };

    $products = $query->paginate(12)->withQueryString();

    // Only show categories that contain at least one active product.
    $categories = Schema::hasTable('product_categories')
        ? ProductCategory::with('children')
            ->withCount(['products' => fn ($products) => $products->where('is_active', true)])
            ->parents()
            ->orderBy('name')
            ->get()
            ->filter(fn ($category) => $category->products_count > 0)
        : collect();

    return view('products.index', compact('products', 'categories', 'logoUrl', 'contactSettings'));
})->name('public.products.index');

Route::get('/products/{product:slug}', function (Product $product) {
    $product->load(['category', 'images']);

    $contactSettings = Schema::hasTable('site_settings')
        ? SiteSetting::contactSettings()
        : SiteSetting::defaultContactSettings();

    $relatedProducts = Product::query()
        ->where('is_active', true)
        ->where('id', '!=', $product->id)
        ->where(function ($query) use ($product) {
            if ($product->product_category_id) {
                $query->where('product_category_id', $product->product_category_id);
            } elseif ($product->category_name) {
                $query->where('category_name', $product->category_name);
            }
        })
        ->with('category')
        ->orderByDesc('updated_at')
        ->take(4)
        ->get();

    return view('products.show', compact('product', 'contactSettings', 'relatedProducts'));
})->name('public.products.show');

Route::get('/quote', [QuoteController::class, 'show'])->name('public.quote');
Route::post('/quote', [QuoteController::class, 'store'])->name('public.quote.store');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('home-page-content', [HomePageContentController::class, 'index'])->name('home-page-content.index');
    Route::post('home-page-content/hero-video', [HomePageContentController::class, 'updateHeroVideo'])->name('home-page-content.hero-video.update');
    Route::post('home-page-content/contact', [HomePageContentController::class, 'updateContact'])->name('home-page-content.contact.update');
    Route::post('home-page-content/main-menu', [HomePageContentController::class, 'updateMainMenu'])->name('home-page-content.main-menu.update');
    Route::get('home-page-content/main-menu/create', [HomePageContentController::class, 'createMenuItem'])->name('home-page-content.main-menu.create');
    Route::post('home-page-content/main-menu/items', [HomePageContentController::class, 'storeMenuItem'])->name('home-page-content.main-menu.store');
    Route::get('home-page-content/main-menu/{index}/edit', [HomePageContentController::class, 'editMenuItem'])->whereNumber('index')->name('home-page-content.main-menu.edit');
    Route::put('home-page-content/main-menu/{index}', [HomePageContentController::class, 'updateMenuItem'])->whereNumber('index')->name('home-page-content.main-menu.item.update');
    Route::delete('home-page-content/main-menu/{index}', [HomePageContentController::class, 'destroyMenuItem'])->whereNumber('index')->name('home-page-content.main-menu.destroy');

    Route::resource('services', ServiceController::class);
    Route::get('sub-categories', [ProductCategoryController::class, 'subcategories'])->name('sub-categories.index');
    Route::resource('categories', ProductCategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('packages', PackageController::class);
    Route::resource('leads', LeadController::class);
    Route::resource('orders', OrderController::class);
    Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('orders/{order}/messages', [OrderMessageController::class, 'store'])->name('orders.messages.store');
    Route::post('orders/{order}/files', [OrderFileController::class, 'store'])->name('orders.files.store');
    Route::resource('invoices', InvoiceController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);

    Route::resource('blog-posts', BlogPostController::class);
    Route::post('blog-posts/bulk', [BlogPostController::class, 'bulkDestroy'])->name('blog-posts.bulk');
    Route::get('pages', [BlogPostController::class, 'index'])->name('pages.index');
    Route::get('new-post', [BlogPostController::class, 'create'])->name('new-post');
    Route::resource('blog-categories', BlogCategoryController::class);
    Route::resource('blog-tags', BlogTagController::class);
    Route::resource('slider-images', \App\Http\Controllers\Admin\SliderImageController::class)->except(['show']);
    Route::resource('work-categories', WorkCategoryController::class)->except(['show']);
    Route::post('site-settings/logo', [SiteLogoController::class, 'store'])->name('site-settings.logo.store');
    Route::delete('site-settings/logo', [SiteLogoController::class, 'destroy'])->name('site-settings.logo.destroy');
    Route::post('site-settings/home-hero-image', [HomeHeroImageController::class, 'store'])->name('site-settings.home-hero-image.store');
    Route::delete('site-settings/home-hero-image', [HomeHeroImageController::class, 'destroy'])->name('site-settings.home-hero-image.destroy');

    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
});
