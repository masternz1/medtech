@extends('layouts.public')

@section('title', 'Shopping Cart — MedEquip Pro')

@section('content')

    <div class="bg-white border-b border-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-slate-500 mb-2 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Home</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold">Shopping Cart</span>
            </nav>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Shopping Cart</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if($cart->items->isEmpty())
            <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center space-y-4 max-w-lg mx-auto shadow-sm">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-slate-900">Your shopping cart is empty</h2>
                <p class="text-xs text-slate-500">
                    You have not added any medical equipment or supplies to your order yet.
                </p>
                <div class="pt-4 flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('products.index') }}" class="px-6 py-2.5 rounded-xl font-bold text-xs bg-slate-900 hover:bg-teal-700 text-white transition shadow-sm">
                        Browse Equipment Catalog
                    </a>
                    <a href="{{ route('quotations.create') }}" class="px-6 py-2.5 rounded-xl font-bold text-xs bg-teal-50 text-teal-700 hover:bg-teal-100 border border-teal-200 transition">
                        Request Custom RFQ
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Items Table (Col 8) -->
                <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Cart Items ({{ $cart->item_count }})</span>
                        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to empty your cart?');">
                            @csrf
                            <button type="submit" class="text-xs font-semibold text-rose-600 hover:underline">
                                Empty Cart
                            </button>
                        </form>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @foreach($cart->items as $item)
                            <div class="p-6 flex flex-col sm:flex-row items-center justify-between gap-6">
                                <div class="flex items-center gap-4 flex-1">
                                    <div class="w-16 h-16 rounded-xl bg-slate-100 p-2 flex items-center justify-center shrink-0 border border-slate-200">
                                        @if($item->product && $item->product->primary_image_url)
                                            <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->name }}" class="max-h-full max-w-full object-contain">
                                        @else
                                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        @endif
                                    </div>
                                    <div class="space-y-1">
                                        <a href="{{ $item->product ? route('products.show', $item->product->slug) : '#' }}" class="font-bold text-sm text-slate-900 hover:text-teal-700 transition">
                                            {{ $item->product?->name ?? 'Equipment Item' }}
                                        </a>
                                        <div class="text-[11px] text-slate-400 flex items-center gap-2">
                                            <span>SKU: {{ $item->product?->sku }}</span>
                                            <span>&bull;</span>
                                            <span>Unit: {{ number_format($item->unit_price, 2) }} {{ config('env.DEFAULT_CURRENCY', 'NGN') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quantity and Subtotal Actions -->
                                <div class="flex items-center gap-6 w-full sm:w-auto justify-between sm:justify-end">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-1.5">
                                        @csrf
                                        @method('PATCH')
                                        <label for="qty_{{ $item->id }}" class="sr-only">Quantity</label>
                                        <input
                                            type="number"
                                            id="qty_{{ $item->id }}"
                                            name="quantity"
                                            value="{{ $item->quantity }}"
                                            min="1"
                                            max="500"
                                            class="w-16 py-1 px-2 text-center text-xs bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                                        />
                                        <button type="submit" class="px-2 py-1 text-[11px] font-semibold bg-slate-100 hover:bg-slate-200 rounded text-slate-700 transition">
                                            Update
                                        </button>
                                    </form>

                                    <div class="text-right">
                                        <span class="text-xs text-slate-400 block sm:hidden">Total</span>
                                        <span class="text-sm font-black text-slate-900">
                                            {{ number_format($item->unit_price * $item->quantity, 2) }} {{ config('env.DEFAULT_CURRENCY', 'NGN') }}
                                        </span>
                                    </div>

                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition" title="Remove item">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="p-6 bg-slate-50/60 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('products.index') }}" class="text-xs font-semibold text-teal-700 hover:underline inline-flex items-center gap-1">
                            <span>&larr;</span>
                            <span>Continue Shopping</span>
                        </a>
                    </div>
                </div>

                <!-- Order Summary Card (Col 4) -->
                <div class="lg:col-span-4 bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-5">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900 border-b border-slate-100 pb-3">
                        Order Summary
                    </h2>

                    <div class="space-y-3 text-xs text-slate-600">
                        <div class="flex justify-between">
                            <span>Equipment Subtotal:</span>
                            <span class="font-semibold text-slate-900">{{ number_format($subtotal, 2) }} {{ config('env.DEFAULT_CURRENCY', 'NGN') }}</span>
                        </div>
                        @if($vatRate > 0)
                            <div class="flex justify-between">
                                <span>Estimated VAT ({{ $vatRate }}%):</span>
                                <span class="font-semibold text-slate-900">{{ number_format($taxAmount, 2) }} {{ config('env.DEFAULT_CURRENCY', 'NGN') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-slate-500">
                            <span>Shipping &amp; Logistics:</span>
                            <span class="italic">Calculated at checkout</span>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex justify-between items-baseline">
                            <span class="text-sm font-bold text-slate-900">Estimated Total:</span>
                            <span class="text-xl font-black text-slate-900">
                                {{ number_format($total, 2) }} {{ config('env.DEFAULT_CURRENCY', 'NGN') }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="w-full py-3.5 px-6 rounded-xl font-bold text-xs text-white bg-slate-900 hover:bg-teal-700 transition shadow-lg text-center block">
                        Proceed to Checkout &rarr;
                    </a>

                    <div class="pt-2 text-[11px] text-slate-400 space-y-1.5">
                        <p class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>PCI-DSS Secured Card &amp; Bank Transfer Checkout</span>
                        </p>
                        <p class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Authentic OEM clinical device warranties</span>
                        </p>
                    </div>
                </div>

            </div>
        @endif
    </div>

@endsection

