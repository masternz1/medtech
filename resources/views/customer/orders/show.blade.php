@extends('layouts.public')

@section('title', 'Order ' . $order->order_number . ' | MedTech Distributions')

@section('content')

    <div class="page-head">
        <div class="shell flex flex-col justify-between gap-3 py-6 md:flex-row md:items-end">
            <div>
                <nav class="crumbs flex gap-x-2" aria-label="Breadcrumb"><a href="{{ route('customer.orders.index') }}">Orders</a><span>/</span><span class="text-slate-700">{{ $order->order_number }}</span></nav>
                <h1 class="mt-5">Order {{ $order->order_number }}</h1>
                <p class="mt-4 text-sm text-slate-500">Placed {{ $order->created_at->format('j M Y, g:i A') }}</p>
            </div>
            <a href="{{ route('orders.track', ['order_number' => $order->order_number, 'email' => $order->guest_email]) }}" class="btn-outline self-start">Track delivery</a>
        </div>
    </div>

    <div class="shell max-w-4xl py-14 sm:py-20">
        <dl class="grid grid-cols-2 gap-y-4 border-y border-slate-200 py-5 text-sm md:grid-cols-4">
            <div><dt class="text-slate-500">Status</dt><dd class="mt-0.5 font-semibold capitalize text-ink">{{ str_replace('_', ' ', $order->status) }}</dd></div>
            <div><dt class="text-slate-500">Payment</dt><dd class="mt-0.5 font-semibold capitalize {{ $order->payment_status === 'paid' ? 'text-emerald-700' : 'text-amber-700' }}">{{ str_replace('_', ' ', $order->payment_status) }}</dd></div>
            <div><dt class="text-slate-500">Delivery</dt><dd class="mt-0.5 font-semibold text-ink">{{ $order->shippingMethod?->name ?? 'Standard' }}</dd></div>
            <div><dt class="text-slate-500">Total</dt><dd class="mt-0.5 font-display text-lg font-bold text-ink">{{ number_format($order->total, 2) }} {{ $order->currency }}</dd></div>
        </dl>

        <h2 class="sec-title mb-3 mt-10">Items</h2>
        <ul class="divide-y divide-slate-200 border-y border-slate-200 text-sm">
            @foreach($order->items as $item)
                <li class="flex justify-between gap-4 py-3">
                    <span><b class="block text-ink">{{ $item->product_name }}</b><span class="text-slate-500">SKU {{ $item->product_sku ?? 'n/a' }}, {{ number_format($item->unit_price, 2) }} each</span></span>
                    <span class="text-right"><span class="block text-slate-500">Qty {{ $item->quantity }}</span><b class="text-ink">{{ number_format($item->subtotal, 2) }} {{ $order->currency }}</b></span>
                </li>
            @endforeach
        </ul>
        <dl class="ml-auto mt-4 max-w-xs space-y-1.5 text-sm text-slate-600">
            <div class="flex justify-between"><dt>Subtotal</dt><dd>{{ number_format($order->subtotal, 2) }}</dd></div>
            <div class="flex justify-between"><dt>Delivery</dt><dd>{{ number_format($order->shipping_cost, 2) }}</dd></div>
            @if($order->tax_amount > 0)<div class="flex justify-between"><dt>VAT</dt><dd>{{ number_format($order->tax_amount, 2) }}</dd></div>@endif
            <div class="flex justify-between border-t border-slate-200 pt-2 font-bold text-ink"><dt>Total ({{ $order->currency }})</dt><dd>{{ number_format($order->total, 2) }}</dd></div>
        </dl>
    </div>

@endsection
