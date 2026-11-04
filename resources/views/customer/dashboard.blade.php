@extends('layouts.public')

@section('title', 'Customer Healthcare Portal — MedEquip Pro')

@section('content')

    <div class="bg-white border-b border-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <span class="text-xs uppercase font-bold text-teal-600 block">Healthcare Institutional Portal</span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Welcome, {{ $user->name }}</h1>
                    <p class="text-xs text-slate-500 mt-1">{{ $user->profile?->organization_name ?? 'Clinical Account' }} &bull; {{ $user->email }}</p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('quotations.create') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-teal-800 bg-teal-50 hover:bg-teal-100 border border-teal-200 transition">
                        + New Quote Request
                    </a>
                    <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-slate-900 hover:bg-teal-700 transition shadow-sm">
                        Browse Equipment
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <!-- Navigation Tabs / Quick Links -->
        <div class="flex gap-2 overflow-x-auto pb-4 mb-8 border-b border-slate-200 text-xs font-bold">
            <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-xl bg-teal-600 text-white shadow-sm">
                Dashboard Overview
            </a>
            <a href="{{ route('customer.orders.index') }}" class="px-4 py-2 rounded-xl bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 transition">
                Orders ({{ $totalOrdersCount }})
            </a>
            <a href="{{ route('customer.quotations.index') }}" class="px-4 py-2 rounded-xl bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 transition">
                Quotations ({{ $totalQuotationsCount }})
            </a>
            <a href="{{ route('customer.addresses.index') }}" class="px-4 py-2 rounded-xl bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 transition">
                Delivery Addresses
            </a>
            <a href="{{ route('profile.edit') }}" class="px-4 py-2 rounded-xl bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 transition">
                Profile Settings
            </a>
        </div>

        <!-- Stats Overview Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                <div>
                    <span class="text-2xl font-black text-slate-900 block">{{ $totalOrdersCount }}</span>
                    <span class="text-xs text-slate-500 font-medium">Total Equipment Orders</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-cyan-50 text-cyan-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <span class="text-2xl font-black text-slate-900 block">{{ $totalQuotationsCount }}</span>
                    <span class="text-xs text-slate-500 font-medium">Quotation Proposals</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <span class="text-sm font-bold text-slate-900 block">NAFDAC Compliant</span>
                    <span class="text-xs text-slate-500 font-medium">Verified Account</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Recent Orders -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-900">Recent Equipment Orders</h2>
                    <a href="{{ route('customer.orders.index') }}" class="text-xs font-semibold text-teal-700 hover:underline">View All &rarr;</a>
                </div>

                @if($recentOrders->isEmpty())
                    <p class="text-xs text-slate-400 py-4 text-center">No orders placed yet.</p>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach($recentOrders as $order)
                            <div class="py-3 flex items-center justify-between text-xs">
                                <div>
                                    <span class="font-bold text-slate-900 block">#{{ $order->order_number }}</span>
                                    <span class="text-slate-400 text-[11px]">{{ $order->created_at->format('M d, Y') }} &bull; {{ $order->items->count() }} items</span>
                                </div>
                                <div class="text-right">
                                    <span class="font-bold text-slate-900 block">{{ number_format($order->total, 2) }} {{ $order->currency }}</span>
                                    <span class="text-[10px] font-bold uppercase text-teal-700">{{ $order->status }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Recent Quotations -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-900">Recent RFQ Quotations</h2>
                    <a href="{{ route('customer.quotations.index') }}" class="text-xs font-semibold text-teal-700 hover:underline">View All &rarr;</a>
                </div>

                @if($recentQuotations->isEmpty())
                    <p class="text-xs text-slate-400 py-4 text-center">No quotation requests submitted yet.</p>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach($recentQuotations as $quote)
                            <div class="py-3 flex items-center justify-between text-xs">
                                <div>
                                    <span class="font-bold text-slate-900 block">{{ $quote->quotation_number }}</span>
                                    <span class="text-slate-400 text-[11px]">{{ $quote->submitted_at?->format('M d, Y') ?? $quote->created_at->format('M d, Y') }} &bull; {{ $quote->items->count() }} items</span>
                                </div>
                                <div class="text-right">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-100 text-slate-700">
                                        {{ $quote->status }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

    </div>

@endsection

