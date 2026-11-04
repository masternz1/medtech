<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * Get or create current cart instance for authenticated user or guest session.
     */
    public function getCart(): Cart
    {
        $userId = Auth::id();
        if (!Session::isStarted()) {
            Session::start();
        }
        $sessionId = Session::getId();

        if ($userId) {
            $cart = Cart::firstOrCreate(
                ['user_id' => $userId],
                ['session_id' => $sessionId, 'expires_at' => now()->addDays(30)]
            );
        } else {
            $cart = Cart::firstOrCreate(
                ['session_id' => $sessionId, 'user_id' => null],
                ['expires_at' => now()->addDays(7)]
            );
        }

        return $cart->load(['items.product.brand', 'items.product.primaryImage']);
    }

    /**
     * Add product to cart.
     */
    public function addItem(int $productId, int $quantity = 1): array
    {
        $product = Product::active()->find($productId);

        if (!$product) {
            return ['success' => false, 'message' => 'Product not found or unavailable.'];
        }

        if ($product->isQuoteOnly()) {
            return ['success' => false, 'message' => 'This product requires a quotation. Please submit a quote request.'];
        }

        $cart = $this->getCart();
        $existingItem = $cart->items->where('product_id', $productId)->first();

        $newQuantity = $existingItem ? $existingItem->quantity + $quantity : $quantity;

        // Check inventory if tracked
        if ($product->inventory && !$product->inventory->allow_backorder) {
            $available = $product->available_stock;
            if ($newQuantity > $available) {
                return [
                    'success' => false,
                    'message' => "Only {$available} unit(s) available in stock."
                ];
            }
        }

        if ($existingItem) {
            $existingItem->update([
                'quantity'   => $newQuantity,
                'unit_price' => $product->price,
            ]);
        } else {
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $productId,
                'quantity'   => $quantity,
                'unit_price' => $product->price,
            ]);
        }

        return [
            'success'    => true,
            'message'    => "{$product->name} added to cart.",
            'cart_count' => $this->getItemCount(),
        ];
    }

    /**
     * Update item quantity in cart.
     */
    public function updateQuantity(int $cartItemId, int $quantity): array
    {
        if ($quantity <= 0) {
            return $this->removeItem($cartItemId);
        }

        $cart = $this->getCart();
        $item = $cart->items()->where('id', $cartItemId)->first();

        if (!$item) {
            return ['success' => false, 'message' => 'Item not found in cart.'];
        }

        $product = $item->product;
        if ($product && $product->inventory && !$product->inventory->allow_backorder) {
            if ($quantity > $product->available_stock) {
                return [
                    'success' => false,
                    'message' => "Only {$product->available_stock} units available in stock."
                ];
            }
        }

        $item->update(['quantity' => $quantity]);

        return [
            'success'    => true,
            'message'    => 'Cart updated successfully.',
            'cart_count' => $this->getItemCount(),
            'subtotal'   => $this->getSubtotal(),
        ];
    }

    /**
     * Remove item from cart.
     */
    public function removeItem(int $cartItemId): array
    {
        $cart = $this->getCart();
        $item = $cart->items()->where('id', $cartItemId)->first();

        if ($item) {
            $item->delete();
        }

        return [
            'success'    => true,
            'message'    => 'Item removed from cart.',
            'cart_count' => $this->getItemCount(),
            'subtotal'   => $this->getSubtotal(),
        ];
    }

    /**
     * Clear all items in cart.
     */
    public function clear(): void
    {
        $cart = $this->getCart();
        $cart->items()->delete();
    }

    /**
     * Total item count.
     */
    public function getItemCount(): int
    {
        return (int) $this->getCart()->items->sum('quantity');
    }

    /**
     * Subtotal cost of items.
     */
    public function getSubtotal(): float
    {
        return (float) $this->getCart()->items->sum(fn($i) => (float) $i->unit_price * $i->quantity);
    }

    /**
     * Merge guest session cart into user's cart on login.
     */
    public function migrateSessionCartToUser(User $user, ?string $sessionId = null): void
    {
        $sessionId = $sessionId ?? Session::getId();
        $sessionCart = Cart::where('session_id', $sessionId)->whereNull('user_id')->first();

        if (!$sessionCart || $sessionCart->items->isEmpty()) {
            return;
        }

        $userCart = Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['session_id' => $sessionId, 'expires_at' => now()->addDays(30)]
        );

        foreach ($sessionCart->items as $item) {
            $existing = $userCart->items()->where('product_id', $item->product_id)->first();
            if ($existing) {
                $existing->update(['quantity' => $existing->quantity + $item->quantity]);
            } else {
                $item->update(['cart_id' => $userCart->id]);
            }
        }

        $sessionCart->delete();
    }
}
