<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image_path',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }

        $uploads = Storage::disk('uploads');
        if ($uploads->exists($this->image_path)) {
            return $uploads->url($this->image_path);
        }

        $public = Storage::disk('public');
        if ($public->exists($this->image_path)) {
            try {
                if (!$uploads->exists($this->image_path)) {
                    $uploads->put($this->image_path, $public->get($this->image_path));
                }
                return $uploads->url($this->image_path);
            } catch (\Throwable $e) {
                return asset('storage/'.$this->image_path);
            }
        }

        return null;
    }
}
