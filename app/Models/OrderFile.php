<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'original_name',
        'path',
        'mime_type',
        'size',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
