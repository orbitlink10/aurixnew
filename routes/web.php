<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\HomeHeroImageController;
use App\Http\Controllers\Admin\WorkCategoryController;
use App\Http\Controllers\Admin\HomePageContentController;
use App\Models\SliderImage;
use App\Models\BlogPost;
use App\Models\SiteSetting;
use App\Models\Service;
use App\Models\WorkCategory;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    $slides = Schema::hasTable('slider_images')
        ? SliderImage::where('is_active', true)->orderBy('sort_order')->orderByDesc('created_at')->get()
        : collect();

    $heroImageUrls = Schema::hasTable('site_settings')
        ? SiteSetting::heroImageUrls()
        : [];

    $workCategories = Schema::hasTable('work_categories')
        ? WorkCategory::where('is_active', true)->orderBy('sort_order')->orderByDesc('created_at')->get()
        : collect();

    $services = Schema::hasTable('services')
        ? Service::where('is_active', true)->orderBy('id')->get()
        : collect();

    return view('welcome', compact('slides', 'heroImageUrls', 'workCategories', 'services'));
});

Route::any('/blog/{probe}', function () {
    abort(404);
})->where('probe', '.*\.php');

Route::get('/blog/{slug}', function (string $slug) {
    $post = BlogPost::where('slug', $slug)->where('status', 'published')->firstOrFail();
    $wordCount = str_word_count(strip_tags($post->body ?? ''));
    $readingTime = max(1, (int) ceil($wordCount / 200));
    return view('blog.show', compact('post', 'readingTime'));
})->name('public.blog.show');

// Backward compatibility for old URLs
Route::get('/blog-posts/{slug}', function (string $slug) {
    return redirect()->route('public.blog.show', ['slug' => $slug], 301);
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('home-page-content', [HomePageContentController::class, 'index'])->name('home-page-content.index');

    Route::resource('services', ServiceController::class);
    Route::resource('products', ProductController::class);
    Route::resource('packages', PackageController::class);
    Route::resource('leads', LeadController::class);
    Route::resource('orders', OrderController::class);
    Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('orders/{order}/messages', [OrderMessageController::class, 'store'])->name('orders.messages.store');
    Route::post('orders/{order}/files', [OrderFileController::class, 'store'])->name('orders.files.store');
    Route::resource('invoices', InvoiceController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);

    Route::resource('blog-posts', BlogPostController::class);
    Route::resource('blog-categories', BlogCategoryController::class);
    Route::resource('blog-tags', BlogTagController::class);
    Route::resource('slider-images', \App\Http\Controllers\Admin\SliderImageController::class)->except(['show']);
    Route::resource('work-categories', WorkCategoryController::class)->except(['show']);
    Route::post('site-settings/home-hero-image', [HomeHeroImageController::class, 'store'])->name('site-settings.home-hero-image.store');
    Route::delete('site-settings/home-hero-image', [HomeHeroImageController::class, 'destroy'])->name('site-settings.home-hero-image.destroy');

    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
});
