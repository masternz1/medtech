@extends('layouts.public')

@section('title', 'Track Medical Equipment Order — MedEquip Pro')

@section('content')

    <div class="bg-white border-b border-slate-200 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-slate-500 mb-2 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Home</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold">Track Shipment</span>
            </nav>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Track Equipment Order</h1>
            <p class="text-sm text-slate-500 mt-1">Enter your order number and email to check live processing and courier delivery status.</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Search Form -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm mb-10">
            <form action="{{ route('orders.track') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
                <div class="sm:col-span-5">
                    <label for="order_number" class="block text-xs font-semibold text-slate-700 mb-1">Order Number *</label>
                    <input
                        type="text"
                        id="order_number"
                        name="order_number"
                        value="{{ request('order_number') }}"
                        required
                        placeholder="ORD-20261104-XXXXX"
                        class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white uppercase font-mono"
                    />
                </div>

                <div class="sm:col-span-5">
                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">Billing / Contact Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ request('email') }}"
                        placeholder="doctor@hospital.org"
                        class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                    />
                </div>

                <div class="sm:col-span-2">
                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl font-bold text-xs text-white bg-slate-900 hover:bg-teal-700 transition shadow-sm">
                        Track Order
                    </button>
                </div>
            </form>
        </div>

        @if(request()->has('order_number'))
            @if($order)
                <!-- Order Result Box -->
                <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm space-y-8">
                    
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-slate-200">
                        <div>
                            <span class="text-xs text-slate-400 block">Shipment Status for</span>
                            <h2 class="text-xl font-black text-slate-900">Order #{{ $order->order_number }}</h2>
                            <p class="text-xs text-slate-500">Placed on {{ $order->created_at->format('M d, Y') }} &bull; Carrier: {{ $order->shippingMethod?->name ?? 'Standard Courier' }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $order->status === 'delivered' ? 'bg-emerald-100 text-emerald-800' : ($order->status === 'cancelled' ? 'bg-rose-100 text-rose-800' : 'bg-teal-100 text-teal-800') }}">
                            {{ $order->status }}
                        </span>
                    </div>

                    <!-- Visual Progress Steps -->
                    <div class="py-4">
                        @php
                            $steps = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'];
                            $currentIndex = array_search($order->status, $steps);
                            if ($currentIndex === false) $currentIndex = 0;
                        @endphp

                        <div class="grid grid-cols-5 gap-2 text-center text-xs">
                            @foreach($steps as $idx => $step)
                                <div class="space-y-2">
                                    <div class="w-8 h-8 mx-auto rounded-full flex items-center justify-center font-bold text-xs transition {{ $idx <= $currentIndex ? 'bg-teal-600 text-white ring-4 ring-teal-100' : 'bg-slate-100 text-slate-400' }}">
                                        @if($idx < $currentIndex)
                                            ✓
                                        @else
                                            {{ $idx + 1 }}
                                        @endif
                                    </div>
                                    <span class="block text-[11px] font-semibold capitalize {{ $idx <= $currentIndex ? 'text-teal-900 font-bold' : 'text-slate-400' }}">
                                        {{ $step }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Items Summary -->
                    <div class="pt-6 border-t border-slate-200 space-y-3">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Order Items</h3>
                        <div class="divide-y divide-slate-100 text-xs">
                            @foreach($order->items as $item)
                                <div class="py-2.5 flex items-center justify-between">
                                    <span class="font-semibold text-slate-900">{{ $item->product_name }}</span>
                                    <span class="text-slate-500">Qty: {{ $item->quantity }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Destination -->
                    <div class="pt-4 border-t border-slate-200 text-xs text-slate-600">
                        <span class="font-bold text-slate-900 block mb-1">Destination Facility:</span>
                        <p>{{ $order->shipping_snapshot['name'] ?? $order->guest_name }}</p>
                        <p>{{ $order->shipping_snapshot['address'] ?? '' }}, {{ $order->shipping_snapshot['city'] ?? '' }}</p>
                    </div>

                </div>
            @else
                <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center space-y-3">
                    <p class="text-sm font-bold text-slate-800">No order found matching {{ request('order_number') }}</p>
                    <p class="text-xs text-slate-500 max-w-md mx-auto">Please check the order reference number in your confirmation email or contact our support team.</p>
                </div>
            @endif
        @endif

    </div>

@endsection

