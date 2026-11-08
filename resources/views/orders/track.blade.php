@extends('layouts.public')

@section('title', 'Track an order | MedTech Distributions')

@section('content')

    <div class="page-head">
        <div class="shell py-12 sm:py-16">
            <nav class="crumbs flex gap-x-2" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><span class="text-slate-700">Track an order</span></nav>
            <h1 class="mt-5">Track an order</h1>
            <p class="mt-4 text-sm text-slate-600">Enter your order number and the email you used at checkout.</p>
        </div>
    </div>

    <div class="shell max-w-3xl py-14 sm:py-20">
        <form action="{{ route('orders.track') }}" method="GET" class="grid items-end gap-4 sm:grid-cols-[1fr_1fr_auto]">
            <div>
                <label for="order_number" class="label">Order number</label>
                <input type="text" id="order_number" name="order_number" value="{{ request('order_number') }}" required placeholder="ORD-20261104-XXXXX" class="field">
            </div>
            <div>
                <label for="email" class="label">Email</label>
                <input type="email" id="email" name="email" value="{{ request('email') }}" placeholder="you@hospital.org" class="field">
            </div>
            <button type="submit" class="btn-primary !py-2.5">Track</button>
        </form>

        @if(request()->has('order_number'))
            @if($order)
                @php
                    $steps = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'];
                    $currentIndex = array_search($order->status, $steps);
                    if ($currentIndex === false) $currentIndex = 0;
                @endphp
                <section class="mt-10 border-t border-slate-200 pt-8">
                    <div class="flex flex-col justify-between gap-2 sm:flex-row sm:items-start">
                        <div>
                            <h2 class="font-display text-xl font-bold text-ink">Order {{ $order->order_number }}</h2>
                            <p class="mt-1 text-sm text-slate-500">Placed {{ $order->created_at->format('j M Y') }} &nbsp;|&nbsp; {{ $order->shippingMethod?->name ?? 'Standard courier' }}</p>
                        </div>
                        <span class="self-start border border-brand-600 px-3 py-1 text-[13px] font-semibold capitalize text-brand-700">{{ str_replace('_', ' ', $order->status) }}</span>
                    </div>

                    <ol class="mt-8 grid grid-cols-5 text-center text-[13px]">
                        @foreach($steps as $idx => $step)
                            <li class="relative">
                                @if(!$loop->last)<span class="absolute left-1/2 top-3.5 h-px w-full {{ $idx < $currentIndex ? 'bg-brand-600' : 'bg-slate-300' }}"></span>@endif
                                <span class="relative mx-auto grid h-7 w-7 place-items-center rounded-full border text-[13px] font-bold {{ $idx <= $currentIndex ? 'border-brand-600 bg-brand-600 text-white' : 'border-slate-300 bg-white text-slate-400' }}">{{ $idx < $currentIndex ? '✓' : $idx + 1 }}</span>
                                <span class="mt-2 block capitalize {{ $idx <= $currentIndex ? 'font-semibold text-ink' : 'text-slate-400' }}">{{ $step }}</span>
                            </li>
                        @endforeach
                    </ol>

                    <div class="mt-10 grid gap-8 text-sm sm:grid-cols-2">
                        <div>
                            <h3 class="mb-2 font-bold text-ink">Items</h3>
                            <ul class="divide-y divide-slate-200 border-y border-slate-200">
                                @foreach($order->items as $item)
                                    <li class="flex justify-between gap-4 py-2"><span>{{ $item->product_name }}</span><span class="text-slate-500">Qty {{ $item->quantity }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                        <div>
                            <h3 class="mb-2 font-bold text-ink">Delivering to</h3>
                            <p class="leading-relaxed text-slate-600">{{ $order->shipping_snapshot['name'] ?? $order->guest_name }}<br>{{ $order->shipping_snapshot['address'] ?? '' }}, {{ $order->shipping_snapshot['city'] ?? '' }}</p>
                        </div>
                    </div>
                </section>
            @else
                <div class="mt-10 border border-slate-300 p-6 text-[15px]">
                    <p class="font-bold text-ink">No order found for {{ request('order_number') }}</p>
                    <p class="mt-1 text-slate-600">Check the reference in your confirmation email, or <a href="{{ route('contact') }}" class="font-semibold text-brand-700 hover:underline">contact us</a>.</p>
                </div>
            @endif
        @endif
    </div>

@endsection
