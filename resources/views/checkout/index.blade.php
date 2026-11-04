@extends('layouts.public')

@section('title', 'Secure Checkout — MedEquip Pro')

@section('content')

    <div class="bg-white border-b border-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-slate-500 mb-2 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Home</a>
                <span>/</span>
                <a href="{{ route('cart.index') }}" class="hover:text-teal-600 transition">Cart</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold">Checkout</span>
            </nav>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Secure Equipment Checkout</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10"
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
         }"
    >
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Main Form (Col 7) -->
                <div class="lg:col-span-7 space-y-8">
                    
                    <!-- Section 1: Customer & Hospital Contact Details -->
                    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                        <div class="border-b border-slate-100 pb-3">
                            <h2 class="text-xs font-bold uppercase tracking-wider text-teal-700">1. Contact &amp; Healthcare Facility Information</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Order confirmation and invoice will be addressed to these details.</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="guest_name" class="block text-xs font-semibold text-slate-700 mb-1">Full Name *</label>
                                <input
                                    type="text"
                                    id="guest_name"
                                    name="guest_name"
                                    value="{{ old('guest_name', $user?->name) }}"
                                    required
                                    class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                                />
                                @error('guest_name') <span class="text-[11px] text-rose-500">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="organization_name" class="block text-xs font-semibold text-slate-700 mb-1">Hospital / Clinic / Organization</label>
                                <input
                                    type="text"
                                    id="organization_name"
                                    name="organization_name"
                                    value="{{ old('organization_name', $user?->profile?->organization_name) }}"
                                    placeholder="e.g. Lagos City General Hospital"
                                    class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                                />
                                @error('organization_name') <span class="text-[11px] text-rose-500">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="guest_email" class="block text-xs font-semibold text-slate-700 mb-1">Official Email Address *</label>
                                <input
                                    type="email"
                                    id="guest_email"
                                    name="guest_email"
                                    value="{{ old('guest_email', $user?->email) }}"
                                    required
                                    class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                                />
                                @error('guest_email') <span class="text-[11px] text-rose-500">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="guest_phone" class="block text-xs font-semibold text-slate-700 mb-1">Phone Number *</label>
                                <input
                                    type="text"
                                    id="guest_phone"
                                    name="guest_phone"
                                    value="{{ old('guest_phone', $user?->profile?->phone) }}"
                                    required
                                    placeholder="+234 800 000 0000"
                                    class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                                />
                                @error('guest_phone') <span class="text-[11px] text-rose-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Delivery & Shipping Address -->
                    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                        <div class="border-b border-slate-100 pb-3">
                            <h2 class="text-xs font-bold uppercase tracking-wider text-teal-700">2. Clinical Delivery Address</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Provide full hospital department/building details for specialized equipment delivery.</p>
                        </div>

                        <div>
                            <label for="shipping_address" class="block text-xs font-semibold text-slate-700 mb-1">Street Address / Facility Building *</label>
                            <input
                                type="text"
                                id="shipping_address"
                                name="shipping_address"
                                value="{{ old('shipping_address', $defaultAddress?->address_line_1) }}"
                                required
                                placeholder="Plot 123 Hospital Road, Central Ward"
                                class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                            />
                            @error('shipping_address') <span class="text-[11px] text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label for="shipping_city" class="block text-xs font-semibold text-slate-700 mb-1">City / Town *</label>
                                <input
                                    type="text"
                                    id="shipping_city"
                                    name="shipping_city"
                                    value="{{ old('shipping_city', $defaultAddress?->city ?? 'Lagos') }}"
                                    required
                                    class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                                />
                            </div>

                            <div>
                                <label for="shipping_state" class="block text-xs font-semibold text-slate-700 mb-1">State / Province *</label>
                                <input
                                    type="text"
                                    id="shipping_state"
                                    name="shipping_state"
                                    value="{{ old('shipping_state', $defaultAddress?->state ?? 'Lagos State') }}"
                                    required
                                    class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                                />
                            </div>

                            <div>
                                <label for="shipping_country" class="block text-xs font-semibold text-slate-700 mb-1">Country *</label>
                                <input
                                    type="text"
                                    id="shipping_country"
                                    name="shipping_country"
                                    value="{{ old('shipping_country', $defaultAddress?->country ?? 'Nigeria') }}"
                                    required
                                    class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                                />
                            </div>
                        </div>

                        <!-- Same Billing Checkbox -->
                        <div class="pt-2">
                            <label class="flex items-center gap-2 cursor-pointer text-xs text-slate-700">
                                <input type="checkbox" name="same_billing" value="1" x-model="sameBilling" class="rounded text-teal-600 focus:ring-teal-500">
                                <span>Billing address matches shipping address</span>
                            </label>
                        </div>

                        <!-- Billing Fields if different -->
                        <div x-show="!sameBilling" x-transition class="space-y-4 pt-4 border-t border-slate-100" style="display: none;">
                            <h3 class="text-xs font-bold text-slate-800 uppercase">Billing Address</h3>
                            <div>
                                <label for="billing_address" class="block text-xs font-semibold text-slate-700 mb-1">Billing Street Address</label>
                                <input type="text" id="billing_address" name="billing_address" class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500">
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <input type="text" name="billing_city" placeholder="City" class="w-full text-xs py-2 px-3 bg-slate-50 border border-slate-300 rounded-xl">
                                <input type="text" name="billing_state" placeholder="State" class="w-full text-xs py-2 px-3 bg-slate-50 border border-slate-300 rounded-xl">
                                <input type="text" name="billing_country" value="Nigeria" class="w-full text-xs py-2 px-3 bg-slate-50 border border-slate-300 rounded-xl">
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Shipping Method Selection -->
                    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                        <div class="border-b border-slate-100 pb-3">
                            <h2 class="text-xs font-bold uppercase tracking-wider text-teal-700">3. Shipping &amp; Logistics Method</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Choose your delivery timeline and handling level.</p>
                        </div>

                        <div class="space-y-3">
                            @foreach($shippingMethods as $method)
                                <label class="flex items-start gap-3 p-4 rounded-2xl border transition cursor-pointer"
                                       :class="{ 'border-teal-600 bg-teal-50/50 ring-2 ring-teal-500/10': selectedMethodId == '{{ $method->id }}', 'border-slate-200 hover:bg-slate-50': selectedMethodId != '{{ $method->id }}' }"
                                >
                                    <input
                                        type="radio"
                                        name="shipping_method_id"
                                        value="{{ $method->id }}"
                                        x-model="selectedMethodId"
                                        class="mt-1 text-teal-600 focus:ring-teal-500"
                                    />
                                    <div class="flex-1 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                                        <div>
                                            <span class="font-bold text-xs text-slate-900">{{ $method->name }}</span>
                                            <p class="text-[11px] text-slate-500 mt-0.5">{{ $method->description }}</p>
                                            <span class="text-[10px] text-teal-700 font-semibold mt-1 inline-block">Estimated: {{ $method->delivery_estimate }}</span>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <span class="font-black text-xs text-slate-900">
                                                {{ $method->base_cost > 0 ? number_format($method->base_cost, 2) . ' ' . config('env.DEFAULT_CURRENCY', 'NGN') : 'Free' }}
                                            </span>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Section 4: Payment Method Selection -->
                    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                        <div class="border-b border-slate-100 pb-3">
                            <h2 class="text-xs font-bold uppercase tracking-wider text-teal-700">4. Payment Gateway &amp; Method</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Select instant card payment, bank transfer, or corporate invoice.</p>
                        </div>

                        <div class="space-y-3">
                            
                            <!-- Paystack -->
                            <label class="flex items-start gap-3 p-4 rounded-2xl border transition cursor-pointer"
                                   :class="{ 'border-teal-600 bg-teal-50/50 ring-2 ring-teal-500/10': paymentMethod === 'paystack', 'border-slate-200 hover:bg-slate-50': paymentMethod !== 'paystack' }"
                            >
                                <input type="radio" name="payment_method" value="paystack" x-model="paymentMethod" class="mt-1 text-teal-600 focus:ring-teal-500">
                                <div>
                                    <span class="font-bold text-xs text-slate-900">Paystack (Cards, Bank Transfer, USSD)</span>
                                    <p class="text-[11px] text-slate-500 mt-0.5">Instant online checkout via debit/credit card, direct bank transfer or USSD.</p>
                                </div>
                            </label>

                            <!-- Flutterwave -->
                            <label class="flex items-start gap-3 p-4 rounded-2xl border transition cursor-pointer"
                                   :class="{ 'border-teal-600 bg-teal-50/50 ring-2 ring-teal-500/10': paymentMethod === 'flutterwave', 'border-slate-200 hover:bg-slate-50': paymentMethod !== 'flutterwave' }"
                            >
                                <input type="radio" name="payment_method" value="flutterwave" x-model="paymentMethod" class="mt-1 text-teal-600 focus:ring-teal-500">
                                <div>
                                    <span class="font-bold text-xs text-slate-900">Flutterwave (Cards &amp; Multi-currency)</span>
                                    <p class="text-[11px] text-slate-500 mt-0.5">Supports Mastercard, Visa, Verve, and West African bank payments.</p>
                                </div>
                            </label>

                            <!-- Direct Bank Transfer -->
                            <label class="flex items-start gap-3 p-4 rounded-2xl border transition cursor-pointer"
                                   :class="{ 'border-teal-600 bg-teal-50/50 ring-2 ring-teal-500/10': paymentMethod === 'bank_transfer', 'border-slate-200 hover:bg-slate-50': paymentMethod !== 'bank_transfer' }"
                            >
                                <input type="radio" name="payment_method" value="bank_transfer" x-model="paymentMethod" class="mt-1 text-teal-600 focus:ring-teal-500">
                                <div>
                                    <span class="font-bold text-xs text-slate-900">Corporate Bank Transfer (Offline Proforma)</span>
                                    <p class="text-[11px] text-slate-500 mt-0.5">Receive immediate bank account details and invoice for corporate procurement wire transfer.</p>
                                </div>
                            </label>

                        </div>

                        <!-- Special Instructions -->
                        <div class="pt-3 border-t border-slate-100">
                            <label for="customer_note" class="block text-xs font-semibold text-slate-700 mb-1">Delivery / Installation Instructions (Optional)</label>
                            <textarea
                                id="customer_note"
                                name="customer_note"
                                rows="2"
                                placeholder="e.g. Deliver to 3rd floor ICU department, ask for Biomedical Engineer John Doe..."
                                class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                            >{{ old('customer_note') }}</textarea>
                        </div>
                    </div>

                </div>

                <!-- Order Review Sidebar (Col 5) -->
                <div class="lg:col-span-5 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6 sticky top-24">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900 border-b border-slate-100 pb-3">
                        Review Your Order Items
                    </h2>

                    <div class="divide-y divide-slate-100 max-h-60 overflow-y-auto pr-1">
                        @foreach($cart->items as $item)
                            <div class="py-3 flex items-center justify-between text-xs gap-3">
                                <div class="flex-1">
                                    <span class="font-bold text-slate-900 block truncate">{{ $item->product?->name }}</span>
                                    <span class="text-[11px] text-slate-500">Qty: {{ $item->quantity }} &times; {{ number_format($item->unit_price, 2) }}</span>
                                </div>
                                <span class="font-bold text-slate-900 shrink-0">
                                    {{ number_format($item->unit_price * $item->quantity, 2) }} {{ config('env.DEFAULT_CURRENCY', 'NGN') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Price Calculations with dynamic Alpine values -->
                    <div class="space-y-2.5 text-xs text-slate-600 pt-3 border-t border-slate-100">
                        <div class="flex justify-between">
                            <span>Equipment Subtotal:</span>
                            <span class="font-bold text-slate-900" x-text="formatMoney(subtotal) + ' {{ config('env.DEFAULT_CURRENCY', 'NGN') }}'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Logistics &amp; Delivery:</span>
                            <span class="font-bold text-teal-700" x-text="formatMoney(shippingCost) + ' {{ config('env.DEFAULT_CURRENCY', 'NGN') }}'"></span>
                        </div>
                        @if($vatRate > 0)
                            <div class="flex justify-between">
                                <span>VAT ({{ $vatRate }}%):</span>
                                <span class="font-bold text-slate-900" x-text="formatMoney(taxAmount) + ' {{ config('env.DEFAULT_CURRENCY', 'NGN') }}'"></span>
                            </div>
                        @endif
                        <div class="pt-3 border-t border-slate-200 flex justify-between items-baseline">
                            <span class="text-sm font-extrabold text-slate-900">Total Payable:</span>
                            <span class="text-2xl font-black text-slate-900" x-text="formatMoney(grandTotal) + ' {{ config('env.DEFAULT_CURRENCY', 'NGN') }}'"></span>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 px-6 rounded-2xl font-black text-xs text-white bg-slate-900 hover:bg-teal-700 transition shadow-xl text-center block tracking-wide">
                        Confirm &amp; Place Order &rarr;
                    </button>

                    <div class="text-[11px] text-slate-400 space-y-1.5 pt-2">
                        <p class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-teal-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Includes verifiable invoice and proof of OEM origin</span>
                        </p>
                        <p class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-teal-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Specialized clinical handling &amp; secure delivery</span>
                        </p>
                    </div>
                </div>

            </div>
        </form>
    </div>

@endsection

