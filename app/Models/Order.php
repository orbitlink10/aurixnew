<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lead_id',
        'package_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'status',
        'subtotal',
        'discount_amount',
        'tax_amount',
        'total',
        'currency',
        'due_date',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'due_date' => 'date',
    ];

    public const STATUSES = ['draft', 'pending', 'in_progress', 'completed', 'cancelled'];

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function messages()
    {
        return $this->hasMany(OrderMessage::class);
    }

    public function files()
    {
        return $this->hasMany(OrderFile::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
