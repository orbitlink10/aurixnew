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
        'meta_description',
        'price',
        'marked_price',
        'quantity',
        'product_category_id',
        'category_name',
        'subcategory_name',
        'image_path',
        'is_active',
        'google_merchant',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'marked_price' => 'decimal:2',
        'quantity' => 'integer',
        'is_active' => 'boolean',
        'google_merchant' => 'boolean',
    ];

    protected $appends = ['image_url', 'gallery_image_urls'];

    public function getImageUrlAttribute(): ?string
    {
        if ($this->image_path) {
            return $this->resolveStoredImageUrl($this->image_path);
        }

        $firstImage = $this->relationLoaded('images')
            ? $this->images->first()
            : $this->images()->first();

        return $firstImage?->image_url;
    }

    public function getGalleryImageUrlsAttribute(): array
    {
        $urls = [];

        if ($this->image_url) {
            $urls[] = $this->image_url;
        }

        $images = $this->relationLoaded('images')
            ? $this->images
            : $this->images()->get();

        foreach ($images as $image) {
            if ($image->image_url) {
                $urls[] = $image->image_url;
            }
        }

        return array_values(array_unique($urls));
    }

    private function resolveStoredImageUrl(string $path): ?string
    {
        $uploads = Storage::disk('uploads');
        if ($uploads->exists($path)) {
            return $uploads->url($path);
        }

        $public = Storage::disk('public');
        if ($public->exists($path)) {
            try {
                if (!$uploads->exists($path)) {
                    $uploads->put($path, $public->get($path));
                }
                return $uploads->url($path);
            } catch (\Throwable $e) {
                return asset('storage/'.$path);
            }
        }

        return null;
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order')->orderBy('id');
    }
}
