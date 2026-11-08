<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'path', 'alt_text', 'sort_order', 'is_primary'];

    protected function casts(): array
    {
        return ['is_primary' => 'boolean'];
    }

    /**
     * Public URL for the photo. Full web addresses are used as they are;
     * files uploaded through the admin panel live on the "public" disk.
     */
    public function getUrlAttribute(): ?string
    {
        $path = $this->path;

        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '/'])) {
            return $path;
        }

        return Storage::disk(static::uploadDisk())->url($path);
    }

    /**
     * Where admin uploads are stored: the default disk when it is a real one (S3 on Vercel),
     * otherwise the local "public" disk.
     */
    public static function uploadDisk(): string
    {
        $default = config('filesystems.default');

        return in_array($default, ['local', null], true) ? 'public' : $default;
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

