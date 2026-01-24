<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SliderImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage_blogs'); // reuse existing permission group
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slides = SliderImage::orderBy('sort_order')->orderByDesc('created_at')->get();

        return view('admin.slider.index', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.slider-images.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'image', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $path = $request->file('image')->store('slider', 'public');

        SliderImage::create([
            'title' => $data['title'] ?? null,
            'caption' => $data['caption'] ?? null,
            'button_text' => $data['button_text'] ?? null,
            'button_url' => $data['button_url'] ?? null,
            'image_path' => $path,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return back()->with('success', 'Slider image added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SliderImage $sliderImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SliderImage $sliderImage)
    {
        $slides = SliderImage::orderBy('sort_order')->orderByDesc('created_at')->get();

        return view('admin.slider.index', compact('slides', 'sliderImage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SliderImage $sliderImage)
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('image')) {
            if ($sliderImage->image_path) {
                Storage::disk('public')->delete($sliderImage->image_path);
            }
            $data['image_path'] = $request->file('image')->store('slider', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $sliderImage->update($data);

        return redirect()->route('admin.slider-images.index')->with('success', 'Slider image updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SliderImage $sliderImage)
    {
        if ($sliderImage->image_path) {
            Storage::disk('public')->delete($sliderImage->image_path);
        }
        $sliderImage->delete();

        return back()->with('success', 'Slider image removed.');
    }
}
