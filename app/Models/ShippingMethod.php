<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $fillable = [
        'name', 'description', 'base_cost', 'free_shipping_threshold',
        'estimated_days_min', 'estimated_days_max', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'base_cost'                => 'decimal:2',
            'free_shipping_threshold'  => 'decimal:2',
            'is_active'                => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getCostForOrder(float $orderTotal): float
    {
        if ($this->free_shipping_threshold && $orderTotal >= $this->free_shipping_threshold) {
            return 0;
        }
        return $this->base_cost;
    }

    public function getDeliveryEstimateAttribute(): string
    {
        if ($this->estimated_days_min && $this->estimated_days_max) {
            return "{$this->estimated_days_min}–{$this->estimated_days_max} business days";
        }
        return 'Contact us for delivery estimate';
    }
}
