<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\WorkCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HomePageContentController extends Controller
{
    public function index(Request $request)
    {
        $heroImageUrls = Schema::hasTable('site_settings')
            ? SiteSetting::heroImageUrls()
            : [];

        $workCategories = Schema::hasTable('work_categories')
            ? WorkCategory::orderBy('sort_order')->orderByDesc('created_at')->get()
            : collect();

        $editingCategory = null;
        if ($request->filled('edit') && Schema::hasTable('work_categories')) {
            $editingCategory = WorkCategory::find($request->integer('edit'));
        }

        return view('admin.home-page-content.index', compact('heroImageUrls', 'workCategories', 'editingCategory'));
    }
}
