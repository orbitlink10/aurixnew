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

        $logoUrl = Schema::hasTable('site_settings')
            ? SiteSetting::logoUrl()
            : null;

        $contactSettings = Schema::hasTable('site_settings')
            ? SiteSetting::contactSettings()
            : SiteSetting::defaultContactSettings();

        $workCategories = Schema::hasTable('work_categories')
            ? WorkCategory::orderBy('sort_order')->orderByDesc('created_at')->get()
            : collect();

        $editingCategory = null;
        if ($request->filled('edit') && Schema::hasTable('work_categories')) {
            $editingCategory = WorkCategory::find($request->integer('edit'));
        }

        return view('admin.home-page-content.index', compact('heroImageUrls', 'logoUrl', 'contactSettings', 'workCategories', 'editingCategory'));
    }

    public function updateContact(Request $request)
    {
        $data = $request->validate([
            'support_label' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'whatsapp_phone' => ['nullable', 'string', 'max:50'],
            'whatsapp_message' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($data as $key => $value) {
            SiteSetting::setValue('contact_'.$key, $value);
        }

        return redirect()->route('admin.home-page-content.index')->with('success', 'Contact details updated.');
    }
}
