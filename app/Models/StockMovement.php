<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    public $timestamps = false;
    const CREATED_AT = 'created_at';

    protected $fillable = [
        'product_id', 'type', 'quantity', 'quantity_before',
        'quantity_after', 'reference_type', 'reference_id', 'notes', 'performed_by',
    ];

    protected function casts(): array
    {
        return ['created_at' => 'datetime'];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function performer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
