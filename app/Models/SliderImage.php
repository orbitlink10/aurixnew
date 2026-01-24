<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
