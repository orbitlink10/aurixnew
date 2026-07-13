<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteLogoController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'logo' => ['required', 'image', 'max:2048'],
        ]);

        $existingPath = SiteSetting::logoPath();
        if ($existingPath) {
            Storage::disk('uploads')->delete($existingPath);
            Storage::disk('public')->delete($existingPath);
        }

        SiteSetting::setLogoPath($request->file('logo')->store('site', 'uploads'));

        return back()->with('success', 'Site logo updated.');
    }

    public function destroy(): RedirectResponse
    {
        $existingPath = SiteSetting::logoPath();
        if ($existingPath) {
            Storage::disk('uploads')->delete($existingPath);
            Storage::disk('public')->delete($existingPath);
        }

        SiteSetting::setLogoPath(null);

        return back()->with('success', 'Site logo removed.');
    }
}
