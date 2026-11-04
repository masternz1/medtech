<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inventory extends Model
{
    public $timestamps = false;
    const UPDATED_AT = 'updated_at';

    protected $table = 'inventory';

    protected $fillable = [
        'product_id', 'quantity', 'reserved_quantity',
        'low_stock_threshold', 'allow_backorder',
    ];

    protected function casts(): array
    {
        return [
            'allow_backorder' => 'boolean',
            'updated_at'      => 'datetime',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getAvailableQuantityAttribute(): int
    {
        return max(0, $this->quantity - $this->reserved_quantity);
    }

    public function isLowStock(): bool
    {
        return $this->available_quantity <= $this->low_stock_threshold && $this->available_quantity > 0;
    }

    public function isOutOfStock(): bool
    {
        return $this->available_quantity <= 0 && !$this->allow_backorder;
    }
}
