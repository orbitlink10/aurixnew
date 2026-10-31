<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeHeroImageController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'hero_images' => ['required', 'array', 'min:1', 'max:12'],
            'hero_images.*' => ['required', 'image', 'max:5120'],
        ]);

        $existingPaths = SiteSetting::heroImagePaths();
        $uploadedPaths = [];

        foreach ($request->file('hero_images', []) as $image) {
            $uploadedPaths[] = $image->store('hero', 'uploads');
        }

        SiteSetting::setHeroImagePaths(array_merge($existingPaths, $uploadedPaths));

        return back()->with('success', 'Homepage hero images uploaded.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        if ($request->exists('image_path')) {
            $data = $request->validate([
                'image_path' => ['required', 'string', \Illuminate\Validation\Rule::in(SiteSetting::heroImagePaths())],
            ]);
            $path = $data['image_path'];
            SiteSetting::setHeroImagePaths(array_values(array_filter(
                SiteSetting::heroImagePaths(), fn ($savedPath) => $savedPath !== $path
            )));
            Storage::disk('uploads')->delete($path);
            Storage::disk('public')->delete($path);

            return back()->with('success', 'Homepage hero image removed.');
        }

        foreach (SiteSetting::heroImagePaths() as $path) {
            Storage::disk('uploads')->delete($path);
            Storage::disk('public')->delete($path); // legacy clean-up
        }

        SiteSetting::setHeroImagePaths([]);

        return back()->with('success', 'Homepage hero images removed.');
    }
}
