@extends('layouts.public')

@section('title', 'Order Receipt #' . $order->order_number . ' — MedEquip Pro')

@section('content')

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        
        <!-- Header Banner -->
        <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 shadow-sm space-y-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-slate-200">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <span class="text-xs uppercase font-bold text-teal-600 block">Order Recorded Successfully</span>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Order #{{ $order->order_number }}</h1>
                        <span class="text-xs text-slate-400">Date: {{ $order->created_at->format('M d, Y - h:i A') }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('orders.pdf', $order->order_number) }}" target="_blank" class="px-4 py-2 text-xs font-semibold text-white bg-slate-900 hover:bg-teal-700 rounded-xl transition inline-flex items-center gap-1.5 shadow-sm">
                        <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Download PDF Invoice</span>
                    </a>
                    <button onclick="window.print()" class="px-4 py-2 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Print</span>
                    </button>
                </div>
            </div>

            <!-- Status Badges Row -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs">
                <div>
                    <span class="text-slate-400 block font-medium">Order Status:</span>
                    <span class="font-bold text-slate-900 uppercase">{{ $order->status }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block font-medium">Payment Status:</span>
                    <span class="font-bold {{ $order->payment_status === 'paid' ? 'text-emerald-600' : 'text-amber-600' }} uppercase">
                        {{ $order->payment_status }}
                    </span>
                </div>
                <div>
                    <span class="text-slate-400 block font-medium">Shipping Method:</span>
                    <span class="font-bold text-slate-900">{{ $order->shippingMethod?->name ?? 'Standard' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block font-medium">Total Amount:</span>
                    <span class="font-black text-slate-900">{{ number_format($order->total, 2) }} {{ $order->currency }}</span>
                </div>
            </div>

            <!-- Bank Transfer Details if Applicable -->
            @if($order->payment_status !== 'paid')
                <div class="p-6 rounded-2xl bg-amber-50/80 border border-amber-200 text-amber-950 space-y-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <h2 class="font-bold text-sm text-amber-950">Bank Transfer Payment Instructions</h2>
                    </div>
                    <p class="text-xs text-amber-800 leading-relaxed">
                        Please transfer the total amount of <strong>{{ number_format($order->total, 2) }} {{ $order->currency }}</strong> to our corporate operations account using your Order Number as the narration.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 text-xs">
                        <div class="bg-white/80 p-3 rounded-xl border border-amber-200">
                            <span class="text-slate-500 block text-[10px] uppercase font-bold">Bank Name</span>
                            <span class="font-bold text-slate-900">Zenith Bank PLC</span>
                        </div>
                        <div class="bg-white/80 p-3 rounded-xl border border-amber-200">
                            <span class="text-slate-500 block text-[10px] uppercase font-bold">Account Name</span>
                            <span class="font-bold text-slate-900">MedEquip Pro Solutions Ltd</span>
                        </div>
                        <div class="bg-white/80 p-3 rounded-xl border border-amber-200">
                            <span class="text-slate-500 block text-[10px] uppercase font-bold">Account Number</span>
                            <span class="font-mono font-black text-slate-900 text-sm">1018942391</span>
                        </div>
                    </div>
                    <p class="text-[11px] text-amber-700">
                        Once paid, email proof of payment to <strong>{{ $siteSettings['company_email'] ?? 'info@medequippro.com' }}</strong> or WhatsApp <strong>{{ $siteSettings['company_whatsapp'] ?? $siteSettings['company_phone'] ?? '+234 000 000 0000' }}</strong> with your order number.
                    </p>
                </div>
            @endif

            <!-- Invoice Itemized Table -->
            <div class="space-y-3">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-900">Ordered Equipment &amp; Supplies</h2>
                <div class="border border-slate-200 rounded-2xl overflow-hidden">
                    <table class="w-full text-left text-xs divide-y divide-slate-200">
                        <thead class="bg-slate-50 font-bold text-slate-700 uppercase text-[10px]">
                            <tr>
                                <th class="p-3.5">Equipment / Item</th>
                                <th class="p-3.5 text-center">SKU</th>
                                <th class="p-3.5 text-center">Qty</th>
                                <th class="p-3.5 text-right">Unit Price</th>
                                <th class="p-3.5 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-800">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="p-3.5 font-semibold text-slate-900">{{ $item->product_name }}</td>
                                    <td class="p-3.5 text-center font-mono text-slate-500">{{ $item->product_sku ?? 'N/A' }}</td>
                                    <td class="p-3.5 text-center font-bold">{{ $item->quantity }}</td>
                                    <td class="p-3.5 text-right">{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="p-3.5 text-right font-black">{{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-slate-50 text-xs font-medium text-slate-700 divide-y divide-slate-200">
                            <tr>
                                <td colspan="4" class="p-3 text-right">Subtotal:</td>
                                <td class="p-3 text-right font-bold text-slate-900">{{ number_format($order->subtotal, 2) }} {{ $order->currency }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="p-3 text-right">Shipping &amp; Logistics:</td>
                                <td class="p-3 text-right font-bold text-slate-900">{{ number_format($order->shipping_cost, 2) }} {{ $order->currency }}</td>
                            </tr>
                            @if($order->tax_amount > 0)
                                <tr>
                                    <td colspan="4" class="p-3 text-right">VAT:</td>
                                    <td class="p-3 text-right font-bold text-slate-900">{{ number_format($order->tax_amount, 2) }} {{ $order->currency }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td colspan="4" class="p-3 text-right font-black text-slate-900 text-sm">Grand Total:</td>
                                <td class="p-3 text-right font-black text-teal-700 text-base">{{ number_format($order->total, 2) }} {{ $order->currency }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Customer & Delivery Snapshot -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-slate-200 text-xs">
                <div class="space-y-1">
                    <span class="font-bold text-slate-900 block text-xs uppercase tracking-wider">Shipping Destination</span>
                    <p class="text-slate-800 font-semibold">{{ $order->shipping_snapshot['name'] ?? $order->guest_name }}</p>
                    @if(!empty($order->shipping_snapshot['organization']))
                        <p class="text-teal-700 font-medium">{{ $order->shipping_snapshot['organization'] }}</p>
                    @endif
                    <p class="text-slate-600">{{ $order->shipping_snapshot['address'] ?? '' }}</p>
                    <p class="text-slate-600">{{ $order->shipping_snapshot['city'] ?? '' }}, {{ $order->shipping_snapshot['state'] ?? '' }}, {{ $order->shipping_snapshot['country'] ?? '' }}</p>
                    <p class="text-slate-500 pt-1">Phone: {{ $order->shipping_snapshot['phone'] ?? $order->guest_phone }}</p>
                </div>

                <div class="space-y-1">
                    <span class="font-bold text-slate-900 block text-xs uppercase tracking-wider">Order Actions</span>
                    <p class="text-slate-600">You can monitor order dispatch, courier tracking number, and biomedical commissioning status anytime.</p>
                    <div class="pt-3 flex flex-wrap gap-2">
                        <a href="{{ route('orders.track', ['order_number' => $order->order_number, 'email' => $order->guest_email]) }}" class="px-4 py-2 rounded-lg font-bold text-xs bg-slate-900 hover:bg-teal-700 text-white transition">
                            Track Shipment &rarr;
                        </a>
                        <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg font-semibold text-xs bg-slate-100 hover:bg-slate-200 text-slate-800 transition">
                            Back to Home
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection

