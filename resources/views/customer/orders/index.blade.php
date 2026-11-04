@extends('layouts.public')

@section('title', 'My Orders — MedEquip Pro')

@section('content')

    <div class="bg-white border-b border-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-slate-500 mb-2 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Home</a>
                <span>/</span>
                <a href="{{ route('dashboard') }}" class="hover:text-teal-600 transition">Portal</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold">Orders</span>
            </nav>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Equipment Order History</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            @if($orders->isEmpty())
                <div class="p-12 text-center space-y-3">
                    <p class="text-sm font-bold text-slate-800">No orders found</p>
                    <p class="text-xs text-slate-500">You have not placed any orders through this account yet.</p>
                    <a href="{{ route('products.index') }}" class="inline-block mt-3 px-5 py-2.5 rounded-xl font-bold text-xs bg-slate-900 text-white hover:bg-teal-700 transition">
                        Explore Medical Equipment
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs divide-y divide-slate-200">
                        <thead class="bg-slate-50 font-bold text-slate-600 uppercase text-[10px]">
                            <tr>
                                <th class="p-4">Order #</th>
                                <th class="p-4">Date</th>
                                <th class="p-4">Items</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Payment</th>
                                <th class="p-4 text-right">Total</th>
                                <th class="p-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-800">
                            @foreach($orders as $order)
                                <tr>
                                    <td class="p-4 font-bold text-slate-900 font-mono">{{ $order->order_number }}</td>
                                    <td class="p-4 text-slate-500">{{ $order->created_at->format('M d, Y') }}</td>
                                    <td class="p-4">{{ $order->items->count() }} item(s)</td>
                                    <td class="p-4">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $order->status === 'delivered' ? 'bg-emerald-100 text-emerald-800' : 'bg-teal-100 text-teal-800' }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                            {{ $order->payment_status }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-right font-black text-slate-900">
                                        {{ number_format($order->total, 2) }} {{ $order->currency }}
                                    </td>
                                    <td class="p-4 text-right">
                                        <a href="{{ route('customer.orders.show', $order->order_number) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-800 transition">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-slate-100">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>

    </div>

@endsection

