<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    public function index(): View
    {
        $cart = $this->cartService->getCart();
        $subtotal = $this->cartService->getSubtotal();
        $vatRate = (float) config('env.VAT_RATE', 0);
        $taxAmount = $subtotal * ($vatRate / 100);
        $total = $subtotal + $taxAmount;

        return view('cart.index', compact('cart', 'subtotal', 'vatRate', 'taxAmount', 'total'));
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['nullable', 'integer', 'min:1', 'max:500'],
        ]);

        $quantity = (int) $request->input('quantity', 1);
        $result = $this->cartService->addItem($request->product_id, $quantity);

        if ($request->wantsJson()) {
            return response()->json($result, $result['success'] ? 200 : 422);
        }

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', $result['message']);
    }

    public function update(Request $request, int $id): RedirectResponse|JsonResponse
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:500'],
        ]);

        $result = $this->cartService->updateQuantity($id, (int) $request->quantity);

        if ($request->wantsJson()) {
            return response()->json($result, $result['success'] ? 200 : 422);
        }

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', $result['message']);
    }

    public function destroy(Request $request, int $id): RedirectResponse|JsonResponse
    {
        $result = $this->cartService->removeItem($id);

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        return back()->with('success', $result['message']);
    }

    public function clear(): RedirectResponse
    {
        $this->cartService->clear();
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully.');
    }
}

