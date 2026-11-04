<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'brand_id', 'name', 'slug', 'sku', 'model_number',
        'short_description', 'description', 'features', 'price', 'compare_price',
        'pricing_type', 'minimum_order_quantity', 'warranty_info', 'weight',
        'status', 'is_featured', 'is_new', 'meta_title', 'meta_description', 'views_count',
    ];

    protected function casts(): array
    {
        return [
            'price'         => 'decimal:2',
            'compare_price' => 'decimal:2',
            'weight'        => 'decimal:2',
            'is_featured'   => 'boolean',
            'is_new'        => 'boolean',
        ];
    }

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class)->orderBy('sort_order');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ProductDocument::class);
    }

    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function quotationItems(): HasMany
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function enquiries(): HasMany
    {
        return $this->hasMany(Enquiry::class);
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('status', 'active');
    }

    public function scopeNew($query)
    {
        return $query->where('is_new', true)->where('status', 'active');
    }

    public function scopeInStock($query)
    {
        return $query->whereHas('inventory', fn($q) => $q->where('quantity', '>', 0));
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function isQuoteOnly(): bool
    {
        return $this->pricing_type === 'quote_only' || $this->price === null;
    }

    public function isInStock(): bool
    {
        if (!$this->inventory) return false;
        $available = $this->inventory->quantity - $this->inventory->reserved_quantity;
        return $available > 0 || $this->inventory->allow_backorder;
    }

    public function getAvailableStockAttribute(): int
    {
        if (!$this->inventory) return 0;
        return max(0, $this->inventory->quantity - $this->inventory->reserved_quantity);
    }

    public function getPrimaryImageUrlAttribute(): ?string
    {
        return $this->primaryImage?->path ?? $this->images->first()?->path;
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->isQuoteOnly()) return 'Request Quote';
        return number_format($this->price, 2) . ' ' . config('env.DEFAULT_CURRENCY', 'NGN');
    }
}
