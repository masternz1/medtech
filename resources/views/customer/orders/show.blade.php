@extends('layouts.public')

@section('title', 'Order #' . $order->order_number . ' — MedEquip Pro')

@section('content')

    <div class="bg-white border-b border-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-slate-500 mb-2 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Home</a>
                <span>/</span>
                <a href="{{ route('dashboard') }}" class="hover:text-teal-600 transition">Portal</a>
                <span>/</span>
                <a href="{{ route('customer.orders.index') }}" class="hover:text-teal-600 transition">Orders</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold">{{ $order->order_number }}</span>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Order #{{ $order->order_number }}</h1>
                    <span class="text-xs text-slate-400">Placed on {{ $order->created_at->format('M d, Y - h:i A') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('orders.track', ['order_number' => $order->order_number, 'email' => $order->guest_email]) }}" class="px-4 py-2 text-xs font-bold bg-slate-900 text-white hover:bg-teal-700 rounded-xl transition">
                        Live Tracking &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
        
        <!-- Status Row -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 bg-white p-5 rounded-3xl border border-slate-200 shadow-sm text-xs">
            <div>
                <span class="text-slate-400 block font-medium">Order Status</span>
                <span class="font-bold text-slate-900 uppercase">{{ $order->status }}</span>
            </div>
            <div>
                <span class="text-slate-400 block font-medium">Payment Status</span>
                <span class="font-bold uppercase {{ $order->payment_status === 'paid' ? 'text-emerald-600' : 'text-amber-600' }}">
                    {{ $order->payment_status }}
                </span>
            </div>
            <div>
                <span class="text-slate-400 block font-medium">Carrier</span>
                <span class="font-bold text-slate-900">{{ $order->shippingMethod?->name ?? 'Standard' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block font-medium">Total Paid / Payable</span>
                <span class="font-black text-slate-900">{{ number_format($order->total, 2) }} {{ $order->currency }}</span>
            </div>
        </div>

        <!-- Items Table -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6 space-y-4">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-900">Equipment Items</h2>
            <div class="divide-y divide-slate-100 text-xs">
                @foreach($order->items as $item)
                    <div class="py-3 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-slate-900 block">{{ $item->product_name }}</span>
                            <span class="text-slate-400 text-[11px]">SKU: {{ $item->product_sku ?? 'N/A' }} &bull; Unit: {{ number_format($item->unit_price, 2) }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-slate-500 block">Qty: {{ $item->quantity }}</span>
                            <span class="font-bold text-slate-900">{{ number_format($item->subtotal, 2) }} {{ $order->currency }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <div class="w-64 space-y-2 text-xs">
                    <div class="flex justify-between text-slate-600">
                        <span>Subtotal:</span>
                        <span>{{ number_format($order->subtotal, 2) }} {{ $order->currency }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Shipping:</span>
                        <span>{{ number_format($order->shipping_cost, 2) }} {{ $order->currency }}</span>
                    </div>
                    @if($order->tax_amount > 0)
                        <div class="flex justify-between text-slate-600">
                            <span>VAT:</span>
                            <span>{{ number_format($order->tax_amount, 2) }} {{ $order->currency }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between font-black text-slate-900 text-sm pt-2 border-t border-slate-200">
                        <span>Grand Total:</span>
                        <span>{{ number_format($order->total, 2) }} {{ $order->currency }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

