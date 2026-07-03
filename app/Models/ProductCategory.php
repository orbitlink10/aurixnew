<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'meta_description',
        'description',
        'image_path',
    ];

    protected $appends = ['image_url'];

    protected static function booted(): void
    {
        static::creating(function (ProductCategory $category) {
            if (! $category->slug) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        $uploads = Storage::disk('uploads');
        if ($uploads->exists($this->image_path)) {
            return $uploads->url($this->image_path);
        }

        $public = Storage::disk('public');
        if ($public->exists($this->image_path)) {
            try {
                if (! $uploads->exists($this->image_path)) {
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
