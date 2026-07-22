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

        $heroVideoUrl = Schema::hasTable('site_settings')
            ? SiteSetting::heroVideoUrl()
            : null;

        $heroVideoEmbedUrl = Schema::hasTable('site_settings')
            ? SiteSetting::heroVideoEmbedUrl()
            : null;

        $logoUrl = Schema::hasTable('site_settings')
            ? SiteSetting::logoUrl()
            : null;

        $contactSettings = Schema::hasTable('site_settings')
            ? SiteSetting::contactSettings()
            : SiteSetting::defaultContactSettings();

        $mainMenuItems = Schema::hasTable('site_settings')
            ? collect(SiteSetting::mainMenuItems())->values()
            : collect(SiteSetting::defaultMainMenuItems())->values();

        $workCategories = Schema::hasTable('work_categories')
            ? WorkCategory::orderBy('sort_order')->orderByDesc('created_at')->get()
            : collect();

        $editingCategory = null;
        if ($request->filled('edit') && Schema::hasTable('work_categories')) {
            $editingCategory = WorkCategory::find($request->integer('edit'));
        }

        return view('admin.home-page-content.index', compact('heroImageUrls', 'heroVideoUrl', 'heroVideoEmbedUrl', 'logoUrl', 'contactSettings', 'mainMenuItems', 'workCategories', 'editingCategory'));
    }

    public function updateHeroVideo(Request $request)
    {
        $data = $request->validate([
            'hero_video_url' => ['nullable', 'string', 'max:500'],
        ]);

        $videoUrl = trim((string) ($data['hero_video_url'] ?? ''));
        if ($videoUrl !== '' && ! SiteSetting::youtubeVideoId($videoUrl)) {
            return back()
                ->withErrors(['hero_video_url' => 'Enter a valid YouTube video URL or video ID.'])
                ->withInput();
        }

        SiteSetting::setHeroVideoUrl($videoUrl ?: null);

        return redirect()->route('admin.home-page-content.index')->with('success', 'Homepage video updated.');
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

    public function updateMainMenu(Request $request)
    {
        $data = $request->validate([
            'main_menu_items' => ['nullable', 'string', 'max:5000'],
        ]);

        SiteSetting::setMainMenuFromText($data['main_menu_items'] ?? null);

        return redirect()->route('admin.home-page-content.index')->with('success', 'Main menu updated.');
    }

    public function createMenuItem()
    {
        return view('admin.home-page-content.menu-form', [
            'isEditing' => false,
            'menuIndex' => null,
            'menuItem' => ['label' => '', 'url' => ''],
        ]);
    }

    public function storeMenuItem(Request $request)
    {
        $items = $this->storedMainMenuItems();
        $items[] = $this->validatedMenuItem($request);

        $this->saveMainMenuItems($items);

        return redirect()->route('admin.home-page-content.index')->with('success', 'Menu item added.');
    }

    public function editMenuItem(int $index)
    {
        $items = $this->storedMainMenuItems();
        abort_unless(isset($items[$index]), 404);

        return view('admin.home-page-content.menu-form', [
            'isEditing' => true,
            'menuIndex' => $index,
            'menuItem' => $items[$index],
        ]);
    }

    public function updateMenuItem(Request $request, int $index)
    {
        $items = $this->storedMainMenuItems();
        abort_unless(isset($items[$index]), 404);

        $items[$index] = $this->validatedMenuItem($request);
        $this->saveMainMenuItems($items);

        return redirect()->route('admin.home-page-content.index')->with('success', 'Menu item updated.');
    }

    public function destroyMenuItem(int $index)
    {
        $items = $this->storedMainMenuItems();
        abort_unless(isset($items[$index]), 404);

        unset($items[$index]);
        $this->saveMainMenuItems(array_values($items));

        return redirect()->route('admin.home-page-content.index')->with('success', 'Menu item removed.');
    }

    private function validatedMenuItem(Request $request): array
    {
        $data = $request->validate([
            'label' => ['required', 'string', 'max:80'],
            'url' => ['required', 'string', 'max:255'],
        ]);

        return [
            'label' => trim($data['label']),
            'url' => trim($data['url']),
        ];
    }

    private function storedMainMenuItems(): array
    {
        return array_values(SiteSetting::mainMenuItems());
    }

    private function saveMainMenuItems(array $items): void
    {
        $cleanItems = collect($items)
            ->map(fn ($item) => [
                'label' => trim((string) ($item['label'] ?? '')),
                'url' => trim((string) ($item['url'] ?? '')),
            ])
            ->filter(fn ($item) => $item['label'] !== '' && $item['url'] !== '')
            ->values()
            ->all();

        SiteSetting::setValue('main_menu_items', count($cleanItems) ? json_encode($cleanItems) : null);
    }
}
