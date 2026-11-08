@extends('layouts.public')

@section('title', 'My orders | MedTech Distributions')

@section('content')

    <div class="page-head">
        <div class="shell py-12 sm:py-16"><h1>My orders</h1></div>
    </div>

    <div class="shell py-6">
        @include('customer._nav')

        @if($orders->isEmpty())
            <div class="py-14 text-center">
                <p class="font-bold text-ink">No orders yet</p>
                <p class="mt-1 text-sm text-slate-500">Orders placed with this account will be listed here.</p>
                <a href="{{ route('products.index') }}" class="btn-primary mt-5">Browse equipment</a>
            </div>
        @else
            <div class="mt-6 overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead><tr class="border-b border-slate-300 text-slate-500">
                        <th class="py-2 pr-4 font-semibold">Order</th><th class="py-2 pr-4 font-semibold">Date</th><th class="py-2 pr-4 font-semibold">Items</th><th class="py-2 pr-4 font-semibold">Status</th><th class="py-2 pr-4 font-semibold">Payment</th><th class="py-2 pr-4 text-right font-semibold">Total</th><th class="py-2"></th>
                    </tr></thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($orders as $order)
                            <tr>
                                <td class="py-3 pr-4 font-semibold text-ink">{{ $order->order_number }}</td>
                                <td class="py-3 pr-4 text-slate-600">{{ $order->created_at->format('j M Y') }}</td>
                                <td class="py-3 pr-4 text-slate-600">{{ $order->items->count() }}</td>
                                <td class="py-3 pr-4 capitalize">{{ str_replace('_', ' ', $order->status) }}</td>
                                <td class="py-3 pr-4 capitalize {{ $order->payment_status === 'paid' ? 'text-emerald-700' : 'text-amber-700' }}">{{ str_replace('_', ' ', $order->payment_status) }}</td>
                                <td class="py-3 pr-4 text-right font-semibold text-ink">{{ number_format($order->total, 2) }} {{ $order->currency }}</td>
                                <td class="py-3 text-right"><a href="{{ route('customer.orders.show', $order->order_number) }}" class="font-semibold text-brand-700 hover:underline">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $orders->links() }}</div>
        @endif
    </div>

@endsection
