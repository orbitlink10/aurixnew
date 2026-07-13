<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SliderImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'caption',
        'button_text',
        'button_url',
        'image_path',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }

        // Primary: uploads disk (served from public/uploads, no symlink required)
        $uploads = Storage::disk('uploads');
        if ($uploads->exists($this->image_path)) {
            return $uploads->url($this->image_path);
        }

        // Fallback: public disk (for existing files) and opportunistically copy forward
        $public = Storage::disk('public');
        if ($public->exists($this->image_path)) {
            try {
                if (!$uploads->exists($this->image_path)) {
                    $uploads->put($this->image_path, $public->get($this->image_path));
                }
                return $uploads->url($this->image_path);
            } catch (\Throwable $e) {
                // If copy fails, still return the original public path
                return asset('storage/'.$this->image_path);
            }
        }

        return null;
    }
}
