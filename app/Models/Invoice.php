<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'number',
        'status',
        'amount',
        'tax_amount',
        'total_amount',
        'due_date',
        'issued_at',
        'paid_at',
        'etims_payload',
        'etims_receipt_number',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'due_date' => 'date',
        'issued_at' => 'datetime',
        'paid_at' => 'datetime',
        'etims_payload' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
