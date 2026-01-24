<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'base_price',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'base_price' => 'decimal:2',
    ];

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
}
