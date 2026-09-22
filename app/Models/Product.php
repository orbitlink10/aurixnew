<?php

namespace App\Models;

use App\Support\UploadedImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    protected $appends = ['image_url'];

    public static function comparableName(string $name): string
    {
        $normalized = Str::of($name)
            ->ascii()
            ->lower()
            ->replaceMatches('/[^a-z0-9]+/', ' ')
            ->squish()
            ->toString();

        return collect(explode(' ', $normalized))
            ->reject(fn ($word) => in_array($word, ['custom'], true))
            ->map(fn ($word) => Str::singular($word))
            ->implode('');
    }

    public function getImageUrlAttribute(): ?string
    {
        return UploadedImage::url($this->image_path);
    }

    public function getDisplayImageUrlAttribute(): ?string
    {
        if ($url = $this->image_url) {
            return $url;
        }

        return $this->images
            ->map(fn (ProductImage $image) => $image->image_url)
            ->first(fn ($url) => filled($url));
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
