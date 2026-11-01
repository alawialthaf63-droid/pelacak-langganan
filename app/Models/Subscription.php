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

    // Geser tanggal tagihan ke periode berikutnya sampai tidak lagi di masa lalu.
    // Mengembalikan true kalau tanggalnya memang bergeser.
    public function advanceBillingDate(): bool
    {
        $date = $this->next_billing_date->copy();
        $moved = false;

        while ($date->lt(today())) {
            $date = $this->billing_cycle === 'yearly'
                ? $date->addYear()
                : $date->addMonthNoOverflow();
            $moved = true;
        }

        if ($moved) {
            $this->update(['next_billing_date' => $date]);
        }

        return $moved;
    }
}