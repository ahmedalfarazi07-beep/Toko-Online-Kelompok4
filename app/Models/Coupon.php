<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'description',
        'type',
        'value',
        'usage_limit',
        'used_count',
        'min_purchase',
        'valid_from',
        'valid_until',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function isValid($totalAmount = null): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->valid_from && now() < $this->valid_from) {
            return false;
        }

        if ($this->valid_until && now() > $this->valid_until) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        if ($this->min_purchase && $totalAmount && $totalAmount < $this->min_purchase) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($amount): float
    {
        if ($this->type === 'fixed') {
            return min($this->value, $amount);
        }

        return round(($amount * $this->value) / 100, 2);
    }
}
