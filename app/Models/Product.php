<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order')->orderBy('id');
    }
}
