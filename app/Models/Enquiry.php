<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enquiry extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'organization',
        'subject', 'message', 'product_id', 'status', 'replied_at', 'ip_address',
    ];

    protected function casts(): array
    {
        return ['replied_at' => 'datetime'];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }
}
