@extends('layouts.public')

@section('title', 'Your account | MedTech Distributions')

@section('content')

    <div class="page-head">
        <div class="shell flex flex-col justify-between gap-4 py-6 md:flex-row md:items-end">
            <div>
                <h1>Hello, {{ $user->name }}</h1>
                <p class="mt-4 text-sm text-slate-500">{{ $user->profile?->organization_name ?? 'Your account' }} &nbsp;|&nbsp; {{ $user->email }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('quotations.create') }}" class="btn-primary">New quote request</a>
                <a href="{{ route('products.index') }}" class="btn-quiet">Browse equipment</a>
            </div>
        </div>
    </div>

    <div class="shell py-6">
        @include('customer._nav')

        <dl class="mt-8 grid grid-cols-2 border-y border-slate-200 text-center">
            <div class="border-r border-slate-200 py-5"><dd class="font-display text-3xl font-bold text-brand-700">{{ $totalOrdersCount }}</dd><dt class="mt-1 text-sm text-slate-500">Orders placed</dt></div>
            <div class="py-5"><dd class="font-display text-3xl font-bold text-brand-700">{{ $totalQuotationsCount }}</dd><dt class="mt-1 text-sm text-slate-500">Quotations</dt></div>
        </dl>

        <div class="mt-10 grid gap-12 lg:grid-cols-2">
            <section>
                <div class="mb-3 flex items-baseline justify-between"><h2 class="font-display text-base font-bold text-ink">Recent orders</h2><a href="{{ route('customer.orders.index') }}" class="text-sm font-semibold text-brand-700 hover:underline">View all</a></div>
                @if($recentOrders->isEmpty())
                    <p class="border-y border-slate-200 py-6 text-sm text-slate-500">No orders placed yet.</p>
                @else
                    <ul class="divide-y divide-slate-200 border-y border-slate-200 text-sm">
                        @foreach($recentOrders as $order)
                            <li>
                                <a href="{{ route('customer.orders.show', $order->order_number) }}" class="flex items-center justify-between gap-4 py-3 hover:text-brand-700">
                                    <span><b class="block text-ink">{{ $order->order_number }}</b><span class="text-slate-500">{{ $order->created_at->format('j M Y') }}, {{ $order->items->count() }} items</span></span>
                                    <span class="text-right"><b class="block text-ink">{{ number_format($order->total, 2) }} {{ $order->currency }}</b><span class="capitalize text-slate-500">{{ str_replace('_', ' ', $order->status) }}</span></span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>

            <section>
                <div class="mb-3 flex items-baseline justify-between"><h2 class="font-display text-base font-bold text-ink">Recent quotations</h2><a href="{{ route('customer.quotations.index') }}" class="text-sm font-semibold text-brand-700 hover:underline">View all</a></div>
                @if($recentQuotations->isEmpty())
                    <p class="border-y border-slate-200 py-6 text-sm text-slate-500">No quotation requests yet.</p>
                @else
                    <ul class="divide-y divide-slate-200 border-y border-slate-200 text-sm">
                        @foreach($recentQuotations as $quote)
                            <li class="flex items-center justify-between gap-4 py-3">
                                <span><b class="block text-ink">{{ $quote->quotation_number }}</b><span class="text-slate-500">{{ ($quote->submitted_at ?? $quote->created_at)->format('j M Y') }}, {{ $quote->items->count() }} items</span></span>
                                <span class="capitalize text-slate-600">{{ str_replace('_', ' ', $quote->status) }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>
        </div>
    </div>

@endsection
