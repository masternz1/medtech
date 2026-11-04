<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id', 'provider', 'reference', 'amount',
        'currency', 'status', 'provider_response', 'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'amount'            => 'decimal:2',
            'provider_response' => 'array',
            'verified_at'       => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function isSuccessful(): bool
    {
        return $this->status === 'successful';
    }

    public function isVerified(): bool
    {
        return $this->verified_at !== null;
    }
}
