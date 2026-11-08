@extends('layouts.public')

@section('title', 'Checkout | MedTech Distributions')

@section('content')

    <div class="page-head">
        <div class="shell py-12 sm:py-16">
            <nav class="crumbs flex gap-x-2" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><a href="{{ route('cart.index') }}">Cart</a><span>/</span><span class="text-slate-700">Checkout</span></nav>
            <h1 class="mt-5">Checkout</h1>
        </div>
    </div>

    <div class="shell py-14 sm:py-20"
         x-data="{
            shippingMethods: {{ json_encode($shippingMethods) }},
            selectedMethodId: '{{ $defaultShipping?->id }}',
            subtotal: {{ (float) $subtotal }},
            vatRate: {{ (float) $vatRate }},
            sameBilling: true,
            paymentMethod: 'paystack',
            get shippingCost() {
                const method = this.shippingMethods.find(m => m.id == this.selectedMethodId);
                if (!method) return 0;
                if (method.free_shipping_threshold && this.subtotal >= method.free_shipping_threshold) {
                    return 0;
                }
                return parseFloat(method.base_cost) || 0;
            },
            get taxAmount() {
                return this.subtotal * (this.vatRate / 100);
            },
            get grandTotal() {
                return this.subtotal + this.shippingCost + this.taxAmount;
            },
            formatMoney(amount) {
                return new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(amount);
            }
         }">
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="grid items-start gap-12 lg:grid-cols-12">

                <div class="space-y-16 lg:col-span-7">

                    <section>
                        <h2 class="sec-title mb-8">1. Your details</h2>
                        <div class="grid gap-4 sm:grid-cols-2">
                        <div >
                            <label for="guest_name" class="label">Full name</label>
                            <input type="text" id="guest_name" name="guest_name" value="{{ old('guest_name', $user?->name) }}" required class="field">
                            @error('guest_name')<p class="mt-1 text-[13px] text-rose-700">{{ $message }}</p>@enderror
                        </div>
                        <div >
                            <label for="organization_name" class="label">Hospital, clinic or company</label>
                            <input type="text" id="organization_name" name="organization_name" value="{{ old('organization_name', $user?->profile?->organization_name) }}" class="field">
                            @error('organization_name')<p class="mt-1 text-[13px] text-rose-700">{{ $message }}</p>@enderror
                        </div>
                        <div >
                            <label for="guest_email" class="label">Email</label>
                            <input type="email" id="guest_email" name="guest_email" value="{{ old('guest_email', $user?->email) }}" required class="field">
                            @error('guest_email')<p class="mt-1 text-[13px] text-rose-700">{{ $message }}</p>@enderror
                        </div>
                        <div >
                            <label for="guest_phone" class="label">Phone</label>
                            <input type="text" id="guest_phone" name="guest_phone" value="{{ old('guest_phone', $user?->profile?->phone) }}" required placeholder="+234 800 000 0000" class="field">
                            @error('guest_phone')<p class="mt-1 text-[13px] text-rose-700">{{ $message }}</p>@enderror
                        </div>
                        </div>
                    </section>

                    <section>
                        <h2 class="sec-title mb-8">2. Delivery address</h2>
                        <div class="grid gap-4 sm:grid-cols-3">
                        <div class="sm:col-span-3">
                            <label for="shipping_address" class="label">Street address and building</label>
                            <input type="text" id="shipping_address" name="shipping_address" value="{{ old('shipping_address', $defaultAddress?->address_line_1) }}" required placeholder="Plot 123 Hospital Road" class="field">
                            @error('shipping_address')<p class="mt-1 text-[13px] text-rose-700">{{ $message }}</p>@enderror
                        </div>
                        <div >
                            <label for="shipping_city" class="label">City or town</label>
                            <input type="text" id="shipping_city" name="shipping_city" value="{{ old('shipping_city', $defaultAddress?->city ?? 'Lagos') }}" required class="field">
                            @error('shipping_city')<p class="mt-1 text-[13px] text-rose-700">{{ $message }}</p>@enderror
                        </div>
                        <div >
                            <label for="shipping_state" class="label">State</label>
                            <input type="text" id="shipping_state" name="shipping_state" value="{{ old('shipping_state', $defaultAddress?->state ?? 'Lagos State') }}" required class="field">
                            @error('shipping_state')<p class="mt-1 text-[13px] text-rose-700">{{ $message }}</p>@enderror
                        </div>
                        <div >
                            <label for="shipping_country" class="label">Country</label>
                            <input type="text" id="shipping_country" name="shipping_country" value="{{ old('shipping_country', $defaultAddress?->country ?? 'Nigeria') }}" required class="field">
                            @error('shipping_country')<p class="mt-1 text-[13px] text-rose-700">{{ $message }}</p>@enderror
                        </div>
                        </div>

                        <label class="mt-4 flex cursor-pointer items-center gap-2 text-sm text-slate-700">
                            <input type="checkbox" name="same_billing" value="1" x-model="sameBilling" class="rounded-sm text-brand-600 focus:ring-brand-600">
                            Billing address is the same as delivery
                        </label>

                        <div x-show="!sameBilling" x-cloak class="mt-4 grid gap-4 border-t border-slate-200 pt-4 sm:grid-cols-3">
                            <div class="sm:col-span-3"><label for="billing_address" class="label">Billing street address</label><input type="text" id="billing_address" name="billing_address" class="field"></div>
                            <input type="text" name="billing_city" placeholder="City" aria-label="Billing city" class="field">
                            <input type="text" name="billing_state" placeholder="State" aria-label="Billing state" class="field">
                            <input type="text" name="billing_country" value="Nigeria" aria-label="Billing country" class="field">
                        </div>
                    </section>

                    <section>
                        <h2 class="sec-title mb-8">3. Delivery method</h2>
                        <div class="space-y-2">
                            @foreach($shippingMethods as $method)
                                <label class="flex cursor-pointer gap-3 border p-4" :class="selectedMethodId == '{{ $method->id }}' ? 'border-brand-600' : 'border-slate-200 hover:border-slate-400'">
                                    <input type="radio" name="shipping_method_id" value="{{ $method->id }}" x-model="selectedMethodId" class="mt-1 text-brand-600 focus:ring-brand-600">
                                    <span class="flex flex-1 justify-between gap-4">
                                        <span>
                                            <b class="block text-[15px] text-ink">{{ $method->name }}</b>
                                            <span class="block text-sm text-slate-600">{{ $method->description }}</span>
                                            <span class="block text-[13px] text-slate-500">Estimated: {{ $method->delivery_estimate }}</span>
                                        </span>
                                        <b class="shrink-0 text-[15px] text-ink">{{ $method->base_cost > 0 ? number_format($method->base_cost, 2) . ' ' . config('env.DEFAULT_CURRENCY', 'NGN') : 'Free' }}</b>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </section>

                    <section>
                        <h2 class="sec-title mb-8">4. Payment</h2>
                        <div class="space-y-2">
                        <label class="flex cursor-pointer gap-3 border p-4" :class="paymentMethod === 'paystack' ? 'border-brand-600' : 'border-slate-200 hover:border-slate-400'">
                            <input type="radio" name="payment_method" value="paystack" x-model="paymentMethod" class="mt-1 text-brand-600 focus:ring-brand-600">
                            <span class="flex-1"><b class="block text-[15px] text-ink">Paystack</b><span class="block text-sm text-slate-600">Pay by card, bank transfer or USSD.</span></span>
                        </label>
                        <label class="flex cursor-pointer gap-3 border p-4" :class="paymentMethod === 'flutterwave' ? 'border-brand-600' : 'border-slate-200 hover:border-slate-400'">
                            <input type="radio" name="payment_method" value="flutterwave" x-model="paymentMethod" class="mt-1 text-brand-600 focus:ring-brand-600">
                            <span class="flex-1"><b class="block text-[15px] text-ink">Flutterwave</b><span class="block text-sm text-slate-600">Mastercard, Visa, Verve and West African bank payments.</span></span>
                        </label>
                        <label class="flex cursor-pointer gap-3 border p-4" :class="paymentMethod === 'bank_transfer' ? 'border-brand-600' : 'border-slate-200 hover:border-slate-400'">
                            <input type="radio" name="payment_method" value="bank_transfer" x-model="paymentMethod" class="mt-1 text-brand-600 focus:ring-brand-600">
                            <span class="flex-1"><b class="block text-[15px] text-ink">Bank transfer against a proforma invoice</b><span class="block text-sm text-slate-600">We send our account details and an invoice for your procurement team.</span></span>
                        </label>
                        </div>

                        <div class="mt-5">
                            <label for="customer_note" class="label">Delivery or installation notes <span class="font-normal text-slate-400">(optional)</span></label>
                            <textarea id="customer_note" name="customer_note" rows="3" class="field" placeholder="For example: deliver to the 3rd floor ICU and ask for the biomedical engineer.">{{ old('customer_note') }}</textarea>
                        </div>
                    </section>
                </div>

                <aside class="border border-slate-200 p-6 lg:sticky lg:top-40 lg:col-span-5">
                    <h2 class="font-display text-base font-bold text-ink">Your order</h2>
                    <ul class="mt-4 divide-y divide-slate-200 border-y border-slate-200 text-sm">
                        @foreach($cart->items as $item)
                            <li class="flex justify-between gap-4 py-3">
                                <span><span class="block font-semibold text-ink">{{ $item->product?->name }}</span><span class="text-slate-500">{{ $item->quantity }} &times; {{ number_format($item->unit_price, 2) }}</span></span>
                                <span class="shrink-0 font-semibold text-ink">{{ number_format($item->unit_price * $item->quantity, 2) }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <dl class="mt-4 space-y-2 text-sm text-slate-600">
                        <div class="flex justify-between"><dt>Subtotal</dt><dd x-text="formatMoney(subtotal)"></dd></div>
                        <div class="flex justify-between"><dt>Delivery</dt><dd x-text="formatMoney(shippingCost)"></dd></div>
                        @if($vatRate > 0)<div class="flex justify-between"><dt>VAT ({{ $vatRate }}%)</dt><dd x-text="formatMoney(taxAmount)"></dd></div>@endif
                        <div class="flex items-baseline justify-between border-t border-slate-200 pt-3 text-ink">
                            <dt class="font-bold">Total ({{ config('env.DEFAULT_CURRENCY', 'NGN') }})</dt>
                            <dd class="font-display text-xl font-bold" x-text="formatMoney(grandTotal)"></dd>
                        </div>
                    </dl>

                    <button type="submit" class="btn-primary mt-5 w-full !py-3.5">Place order</button>
                    <p class="mt-3 text-[13px] leading-relaxed text-slate-500">You will be sent to the payment page next. An invoice is emailed after your order is placed.</p>
                </aside>
            </div>
        </form>
    </div>

@endsection
