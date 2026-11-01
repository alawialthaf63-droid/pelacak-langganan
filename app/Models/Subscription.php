<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'name',
        'price',
        'billing_cycle',
        'next_billing_date',
        'category',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'next_billing_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    // Harga per bulan: langganan tahunan dibagi 12.
    public function getMonthlyCostAttribute(): float
    {
        return $this->billing_cycle === 'yearly'
            ? $this->price / 12
            : $this->price;
    }
}