<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'service_id',
        'budget',
        'description',
        'status',
        'assigned_to',
        'contacted_at',
        'quoted_at',
        'closed_at',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'contacted_at' => 'datetime',
        'quoted_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
