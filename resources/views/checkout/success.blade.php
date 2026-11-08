@extends('layouts.public')

@section('title', 'Order ' . $order->order_number . ' | MedTech Distributions')

@section('content')

    <div class="page-head">
        <div class="shell flex flex-col justify-between gap-4 py-6 md:flex-row md:items-end">
            <div>
                <p class="text-sm font-semibold text-emerald-700">Thank you, your order has been recorded</p>
                <h1 class="mt-4">Order {{ $order->order_number }}</h1>
                <p class="mt-4 text-sm text-slate-500">Placed {{ $order->created_at->format('j M Y, g:i A') }}</p>
            </div>
            <div class="flex gap-3 print:hidden">
                <a href="{{ route('orders.pdf', $order->order_number) }}" target="_blank" class="btn-outline">Download invoice (PDF)</a>
                <button onclick="window.print()" class="btn-quiet">Print</button>
            </div>
        </div>
    </div>

    <div class="shell max-w-4xl py-14 sm:py-20">

        <dl class="grid grid-cols-2 gap-y-4 border-y border-slate-200 py-5 text-sm md:grid-cols-4">
            <div><dt class="text-slate-500">Order status</dt><dd class="mt-0.5 font-semibold capitalize text-ink">{{ str_replace('_', ' ', $order->status) }}</dd></div>
            <div><dt class="text-slate-500">Payment</dt><dd class="mt-0.5 font-semibold capitalize {{ $order->payment_status === 'paid' ? 'text-emerald-700' : 'text-amber-700' }}">{{ str_replace('_', ' ', $order->payment_status) }}</dd></div>
            <div><dt class="text-slate-500">Delivery</dt><dd class="mt-0.5 font-semibold text-ink">{{ $order->shippingMethod?->name ?? 'Standard' }}</dd></div>
            <div><dt class="text-slate-500">Total</dt><dd class="mt-0.5 font-display text-lg font-bold text-ink">{{ number_format($order->total, 2) }} {{ $order->currency }}</dd></div>
        </dl>

        @if($order->payment_status !== 'paid')
            <section class="mt-8 border border-slate-300 p-6">
                <h2 class="font-display text-base font-bold text-ink">To pay by bank transfer</h2>
                @if(!empty($siteSettings['bank_account_number']))
                    <p class="mt-2 text-[15px] leading-relaxed text-slate-600">Transfer <b class="text-ink">{{ number_format($order->total, 2) }} {{ $order->currency }}</b> to the account below and use <b class="text-ink">{{ $order->order_number }}</b> as the payment reference.</p>
                    <dl class="mt-4 grid gap-4 text-[15px] sm:grid-cols-3">
                        <div><dt class="text-slate-500">Bank</dt><dd class="font-semibold text-ink">{{ $siteSettings['bank_name'] ?? '' }}</dd></div>
                        <div><dt class="text-slate-500">Account name</dt><dd class="font-semibold text-ink">{{ $siteSettings['bank_account_name'] ?? $company['name'] }}</dd></div>
                        <div><dt class="text-slate-500">Account number</dt><dd class="font-mono font-semibold text-ink">{{ $siteSettings['bank_account_number'] }}</dd></div>
                    </dl>
                @else
                    <p class="mt-2 text-[15px] leading-relaxed text-slate-600">We will send our bank details for <b class="text-ink">{{ number_format($order->total, 2) }} {{ $order->currency }}</b> with the invoice. Quote <b class="text-ink">{{ $order->order_number }}</b> as the payment reference.</p>
                @endif
                <p class="mt-4 text-[15px] text-slate-600">After paying, send proof of payment through our <a href="{{ route('contact') }}" class="font-semibold text-brand-700 hover:underline">contact page</a>@if($company['email']) or to <a href="mailto:{{ $company['email'] }}" class="font-semibold text-brand-700 hover:underline">{{ $company['email'] }}</a>@endif.</p>
            </section>
        @endif

        <section class="mt-10">
            <h2 class="sec-title mb-8">Items</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-300 text-left text-slate-500">
                            <th class="py-2 pr-4 font-semibold">Item</th>
                            <th class="py-2 pr-4 font-semibold">SKU</th>
                            <th class="py-2 pr-4 text-right font-semibold">Qty</th>
                            <th class="py-2 pr-4 text-right font-semibold">Unit price</th>
                            <th class="py-2 text-right font-semibold">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="py-3 pr-4 font-semibold text-ink">{{ $item->product_name }}</td>
                                <td class="py-3 pr-4 text-slate-500">{{ $item->product_sku ?? 'n/a' }}</td>
                                <td class="py-3 pr-4 text-right">{{ $item->quantity }}</td>
                                <td class="py-3 pr-4 text-right">{{ number_format($item->unit_price, 2) }}</td>
                                <td class="py-3 text-right font-semibold text-ink">{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t border-slate-300 text-slate-600">
                        <tr><td colspan="4" class="pt-3 text-right">Subtotal</td><td class="pt-3 text-right">{{ number_format($order->subtotal, 2) }}</td></tr>
                        <tr><td colspan="4" class="pt-1 text-right">Delivery</td><td class="pt-1 text-right">{{ number_format($order->shipping_cost, 2) }}</td></tr>
                        @if($order->tax_amount > 0)<tr><td colspan="4" class="pt-1 text-right">VAT</td><td class="pt-1 text-right">{{ number_format($order->tax_amount, 2) }}</td></tr>@endif
                        <tr class="text-ink"><td colspan="4" class="pt-2 text-right font-bold">Total ({{ $order->currency }})</td><td class="pt-2 text-right font-display text-base font-bold">{{ number_format($order->total, 2) }}</td></tr>
                    </tfoot>
                </table>
            </div>
        </section>

        <div class="mt-10 grid gap-8 border-t border-slate-200 pt-8 text-sm md:grid-cols-2">
            <div>
                <h2 class="mb-2 font-display text-base font-bold text-ink">Delivering to</h2>
                <address class="not-italic leading-relaxed text-slate-600">
                    <b class="text-ink">{{ $order->shipping_snapshot['name'] ?? $order->guest_name }}</b><br>
                    @if(!empty($order->shipping_snapshot['organization'])){{ $order->shipping_snapshot['organization'] }}<br>@endif
                    {{ $order->shipping_snapshot['address'] ?? '' }}<br>
                    {{ $order->shipping_snapshot['city'] ?? '' }}, {{ $order->shipping_snapshot['state'] ?? '' }}, {{ $order->shipping_snapshot['country'] ?? '' }}<br>
                    Phone: {{ $order->shipping_snapshot['phone'] ?? $order->guest_phone }}
                </address>
            </div>
            <div class="print:hidden">
                <h2 class="mb-2 font-display text-base font-bold text-ink">What next</h2>
                <p class="leading-relaxed text-slate-600">You can follow dispatch and delivery at any time.</p>
                <div class="mt-4 flex gap-3">
                    <a href="{{ route('orders.track', ['order_number' => $order->order_number, 'email' => $order->guest_email]) }}" class="btn-primary">Track this order</a>
                    <a href="{{ route('home') }}" class="btn-quiet">Back to the shop</a>
                </div>
            </div>
        </div>
    </div>

@endsection
