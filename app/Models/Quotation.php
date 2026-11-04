<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'quotation_number', 'status', 'organization_name',
        'contact_name', 'contact_email', 'contact_phone', 'country',
        'requirements', 'admin_notes', 'terms', 'subtotal', 'valid_until',
        'order_id', 'pdf_path', 'submitted_at', 'quoted_at', 'accepted_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal'     => 'decimal:2',
            'valid_until'  => 'date',
            'submitted_at' => 'datetime',
            'quoted_at'    => 'datetime',
            'accepted_at'  => 'datetime',
        ];
    }

    const STATUS_DRAFT       = 'draft';
    const STATUS_SUBMITTED   = 'submitted';
    const STATUS_UNDER_REVIEW = 'under_review';
    const STATUS_QUOTED      = 'quoted';
    const STATUS_ACCEPTED    = 'accepted';
    const STATUS_REJECTED    = 'rejected';
    const STATUS_CONVERTED   = 'converted';
    const STATUS_EXPIRED     = 'expired';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(QuotationDocument::class);
    }

    public function isExpired(): bool
    {
        return $this->valid_until && $this->valid_until->isPast();
    }

    public static function generateNumber(): string
    {
        do {
            $number = 'QT-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
        } while (self::where('quotation_number', $number)->exists());
        return $number;
    }
}
