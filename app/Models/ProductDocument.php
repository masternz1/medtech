<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductDocument extends Model
{
    protected $fillable = ['product_id', 'name', 'type', 'path', 'mime_type', 'size'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getFormattedSizeAttribute(): string
    {
        if (!$this->size) return 'Unknown';
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = floor(log($this->size, 1024));
        return round($this->size / pow(1024, $i), 2) . ' ' . $units[$i];
    }
}
