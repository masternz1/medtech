<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Models\StockMovement;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    public function index(): View|RedirectResponse
    {
        $cart = $this->cartService->getCart();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('info', 'Your cart is empty. Add equipment before checkout.');
        }

        $subtotal = $this->cartService->getSubtotal();
        $shippingMethods = ShippingMethod::active()->get();
        $defaultShipping = $shippingMethods->first();
        $shippingCost = $defaultShipping ? $defaultShipping->getCostForOrder($subtotal) : 0;
        $vatRate = (float) config('env.VAT_RATE', 0);
        $taxAmount = $subtotal * ($vatRate / 100);
        $total = $subtotal + $shippingCost + $taxAmount;

        $user = Auth::user();
        $defaultAddress = $user?->defaultShippingAddress;

        return view('checkout.index', compact(
            'cart',
            'subtotal',
            'shippingMethods',
            'defaultShipping',
            'shippingCost',
            'vatRate',
            'taxAmount',
            'total',
            'user',
            'defaultAddress'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $cart = $this->cartService->getCart();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty.');
        }

        $validated = $request->validate([
            'guest_name'          => ['required', 'string', 'max:255'],
            'guest_email'         => ['required', 'email', 'max:255'],
            'guest_phone'         => ['required', 'string', 'max:50'],
            'organization_name'   => ['nullable', 'string', 'max:255'],
            'shipping_method_id'  => ['required', 'exists:shipping_methods,id'],
            'payment_method'      => ['required', 'in:paystack,flutterwave,bank_transfer'],
            'customer_note'       => ['nullable', 'string', 'max:1000'],

            // Shipping Address
            'shipping_address'    => ['required', 'string', 'max:255'],
            'shipping_city'       => ['required', 'string', 'max:100'],
            'shipping_state'      => ['required', 'string', 'max:100'],
            'shipping_country'    => ['required', 'string', 'max:100'],
            'shipping_postal_code'=> ['nullable', 'string', 'max:20'],

            // Billing Address
            'same_billing'        => ['nullable', 'boolean'],
            'billing_address'     => ['nullable', 'string', 'max:255'],
            'billing_city'        => ['nullable', 'string', 'max:100'],
            'billing_state'       => ['nullable', 'string', 'max:100'],
            'billing_country'     => ['nullable', 'string', 'max:100'],
        ]);

        $subtotal = $this->cartService->getSubtotal();
        $shippingMethod = ShippingMethod::findOrFail($validated['shipping_method_id']);
        $shippingCost = $shippingMethod->getCostForOrder($subtotal);
        $vatRate = (float) config('env.VAT_RATE', 0);
        $taxAmount = $subtotal * ($vatRate / 100);
        $total = $subtotal + $shippingCost + $taxAmount;

        $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        $shippingSnapshot = [
            'name'         => $validated['guest_name'],
            'organization' => $validated['organization_name'] ?? null,
            'email'        => $validated['guest_email'],
            'phone'        => $validated['guest_phone'],
            'address'      => $validated['shipping_address'],
            'city'         => $validated['shipping_city'],
            'state'        => $validated['shipping_state'],
            'country'      => $validated['shipping_country'],
            'postal_code'  => $validated['shipping_postal_code'] ?? null,
            'method'       => $shippingMethod->name,
        ];

        $billingSnapshot = !empty($validated['same_billing']) ? $shippingSnapshot : [
            'name'         => $validated['guest_name'],
            'address'      => $validated['billing_address'] ?? $validated['shipping_address'],
            'city'         => $validated['billing_city'] ?? $validated['shipping_city'],
            'state'        => $validated['billing_state'] ?? $validated['shipping_state'],
            'country'      => $validated['billing_country'] ?? $validated['shipping_country'],
        ];

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id'            => Auth::id(),
                'order_number'       => $orderNumber,
                'status'             => Order::STATUS_PENDING,
                'payment_status'     => Order::PAYMENT_PENDING,
                'subtotal'           => $subtotal,
                'shipping_cost'      => $shippingCost,
                'tax_amount'         => $taxAmount,
                'discount_amount'    => 0,
                'total'              => $total,
                'currency'           => config('env.DEFAULT_CURRENCY', 'NGN'),
                'shipping_method_id' => $shippingMethod->id,
                'customer_note'      => $validated['customer_note'] ?? null,
                'billing_snapshot'   => $billingSnapshot,
                'shipping_snapshot'  => $shippingSnapshot,
                'guest_name'         => $validated['guest_name'],
                'guest_email'        => $validated['guest_email'],
                'guest_phone'        => $validated['guest_phone'],
            ]);

            // Create order items & adjust inventory
            foreach ($cart->items as $item) {
                $product = $item->product;

                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $product ? $product->name : 'Equipment Item',
                    'product_sku'  => $product ? $product->sku : null,
                    'quantity'     => $item->quantity,
                    'unit_price'   => $item->unit_price,
                    'subtotal'     => $item->unit_price * $item->quantity,
                ]);

                // Inventory decrement and log
                if ($product && $product->inventory) {
                    $inv = $product->inventory;
                    $qtyBefore = $inv->quantity;
                    $qtyAfter = max(0, $qtyBefore - $item->quantity);
                    $inv->update(['quantity' => $qtyAfter]);

                    StockMovement::create([
                        'product_id'      => $product->id,
                        'type'            => 'sale',
                        'quantity'        => -$item->quantity,
                        'quantity_before' => $qtyBefore,
                        'quantity_after'  => $qtyAfter,
                        'reference_type'  => 'order',
                        'reference_id'    => $order->id,
                        'notes'           => "Order #{$orderNumber}",
                        'performed_by'    => Auth::id(),
                    ]);
                }
            }

            // Create initial payment record
            $payment = Payment::create([
                'order_id'  => $order->id,
                'provider'  => $validated['payment_method'],
                'reference' => 'PAY-' . strtoupper(Str::random(12)),
                'amount'    => $total,
                'currency'  => $order->currency,
                'status'    => 'pending',
            ]);

            DB::commit();

            // Clear user cart
            $this->cartService->clear();

            // Route based on payment provider
            if ($validated['payment_method'] === 'bank_transfer') {
                return redirect()->route('checkout.success', ['orderNumber' => $order->order_number])
                    ->with('info', 'Please complete payment using the bank transfer details below.');
            }

            if ($validated['payment_method'] === 'paystack') {
                return $this->initializePaystack($order, $payment);
            }

            if ($validated['payment_method'] === 'flutterwave') {
                return $this->initializeFlutterwave($order, $payment);
            }

            return redirect()->route('checkout.success', ['orderNumber' => $order->order_number]);

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Checkout processing error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while creating your order: ' . $e->getMessage());
        }
    }

    /**
     * Initialize Paystack transaction.
     */
    protected function initializePaystack(Order $order, Payment $payment): RedirectResponse
    {
        $secretKey = config('paystack.secret_key');
        if (!$secretKey || $secretKey === 'YOUR_PAYSTACK_SECRET_KEY') {
            // Local dev fallback when real API key is pending
            return redirect()->route('checkout.success', ['orderNumber' => $order->order_number])
                ->with('warning', 'Paystack sandbox mode (keys not set). Order recorded successfully.');
        }

        try {
            $response = Http::withToken($secretKey)
                ->post('https://api.paystack.co/transaction/initialize', [
                    'email'        => $order->guest_email,
                    'amount'       => (int) ($order->total * 100), // In kobo
                    'reference'    => $payment->reference,
                    'callback_url' => route('checkout.callback.paystack', ['reference' => $payment->reference]),
                    'metadata'     => [
                        'order_id'     => $order->id,
                        'order_number' => $order->order_number,
                    ],
                ]);

            if ($response->successful() && $response->json('status')) {
                return redirect()->away($response->json('data.authorization_url'));
            }
        } catch (\Throwable $e) {
            Log::error('Paystack initialization error: ' . $e->getMessage());
        }

        return redirect()->route('checkout.success', ['orderNumber' => $order->order_number])
            ->with('warning', 'Payment gateway could not be reached. Order saved, please proceed with bank transfer or retry.');
    }

    /**
     * Initialize Flutterwave transaction.
     */
    protected function initializeFlutterwave(Order $order, Payment $payment): RedirectResponse
    {
        $secretKey = config('flutterwave.secret_key');
        if (!$secretKey || $secretKey === 'YOUR_FLUTTERWAVE_SECRET_KEY') {
            return redirect()->route('checkout.success', ['orderNumber' => $order->order_number])
                ->with('warning', 'Flutterwave sandbox mode. Order recorded successfully.');
        }

        try {
            $response = Http::withToken($secretKey)
                ->post('https://api.flutterwave.com/v3/payments', [
                    'tx_ref'          => $payment->reference,
                    'amount'          => $order->total,
                    'currency'        => $order->currency,
                    'redirect_url'    => route('checkout.callback.flutterwave'),
                    'customer'        => [
                        'email'        => $order->guest_email,
                        'phonenumber'  => $order->guest_phone,
                        'name'         => $order->guest_name,
                    ],
                    'customizations'  => [
                        'title'        => 'MedEquip Pro Order ' . $order->order_number,
                        'description'  => 'Payment for medical equipment',
                    ],
                ]);

            if ($response->successful() && $response->json('status') === 'success') {
                return redirect()->away($response->json('data.link'));
            }
        } catch (\Throwable $e) {
            Log::error('Flutterwave initialization error: ' . $e->getMessage());
        }

        return redirect()->route('checkout.success', ['orderNumber' => $order->order_number])
            ->with('warning', 'Payment gateway could not be reached. Order saved.');
    }

    /**
     * Paystack return callback.
     */
    public function paystackCallback(Request $request): RedirectResponse
    {
        $reference = $request->query('reference');
        $payment = Payment::where('reference', $reference)->with('order')->firstOrFail();

        $secretKey = config('paystack.secret_key');
        if ($secretKey && $secretKey !== 'YOUR_PAYSTACK_SECRET_KEY') {
            $verify = Http::withToken($secretKey)
                ->get("https://api.paystack.co/transaction/verify/{$reference}");

            if ($verify->successful() && $verify->json('data.status') === 'success') {
                $payment->update([
                    'status'            => 'successful',
                    'provider_response' => $verify->json(),
                    'verified_at'       => now(),
                ]);
                $payment->order->update([
                    'status'         => Order::STATUS_CONFIRMED,
                    'payment_status' => Order::PAYMENT_PAID,
                ]);
                return redirect()->route('checkout.success', ['orderNumber' => $payment->order->order_number])
                    ->with('success', 'Payment verified successfully! Thank you for your order.');
            }
        }

        return redirect()->route('checkout.success', ['orderNumber' => $payment->order->order_number])
            ->with('info', 'Payment status is pending verification.');
    }

    /**
     * Flutterwave return callback.
     */
    public function flutterwaveCallback(Request $request): RedirectResponse
    {
        $status = $request->query('status');
        $txRef = $request->query('tx_ref');

        $payment = Payment::where('reference', $txRef)->with('order')->firstOrFail();

        if ($status === 'successful' || $status === 'completed') {
            $payment->update([
                'status'      => 'successful',
                'verified_at' => now(),
            ]);
            $payment->order->update([
                'status'         => Order::STATUS_CONFIRMED,
                'payment_status' => Order::PAYMENT_PAID,
            ]);
            return redirect()->route('checkout.success', ['orderNumber' => $payment->order->order_number])
                ->with('success', 'Payment verified successfully!');
        }

        return redirect()->route('checkout.success', ['orderNumber' => $payment->order->order_number]);
    }

    /**
     * Order success page.
     */
    public function success(string $orderNumber): View
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items.product', 'shippingMethod', 'payments'])
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }

    /**
     * Track Order page.
     */
    public function track(Request $request): View
    {
        $order = null;
        if ($orderNumber = $request->input('order_number')) {
            $email = $request->input('email');
            $order = Order::where('order_number', trim($orderNumber))
                ->when($email, fn($q) => $q->where('guest_email', trim($email)))
                ->with(['items.product', 'shippingMethod'])
                ->first();
        }

        return view('orders.track', compact('order'));
    }
}

