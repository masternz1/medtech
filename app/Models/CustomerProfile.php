<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'organization_name',
        'organization_type',
        'country',
        'avatar',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getOrganizationTypeLabelAttribute(): string
    {
        return match ($this->organization_type) {
            'hospital'   => 'Hospital',
            'clinic'     => 'Clinic',
            'laboratory' => 'Laboratory',
            'pharmacy'   => 'Pharmacy',
            'individual' => 'Individual',
            default      => ucfirst($this->organization_type ?? 'Unknown'),
        };
    }
}
