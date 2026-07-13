<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_path',
        'base_price',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'base_price' => 'decimal:2',
    ];

    protected $appends = ['image_url'];

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
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
}
