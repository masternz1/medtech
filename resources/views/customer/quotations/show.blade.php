@extends('layouts.public')

@section('title', 'Quotation ' . $quotation->quotation_number . ' — MedEquip Pro')

@section('content')

    <div class="bg-white border-b border-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-slate-500 mb-2 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Home</a>
                <span>/</span>
                <a href="{{ route('dashboard') }}" class="hover:text-teal-600 transition">Portal</a>
                <span>/</span>
                <a href="{{ route('customer.quotations.index') }}" class="hover:text-teal-600 transition">Quotations</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold">{{ $quotation->quotation_number }}</span>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Quotation Proposal #{{ $quotation->quotation_number }}</h1>
                    <span class="text-xs text-slate-400">Submitted on {{ $quotation->submitted_at?->format('M d, Y') ?? $quotation->created_at->format('M d, Y') }} &bull; Facility: {{ $quotation->organization_name }}</span>
                </div>
                <div class="flex items-center gap-2 self-start">
                    <a href="{{ route('quotations.pdf', $quotation->quotation_number) }}" target="_blank" class="px-4 py-2 text-xs font-semibold text-white bg-slate-900 hover:bg-teal-700 rounded-xl transition inline-flex items-center gap-1.5 shadow-sm">
                        <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Download Official PDF</span>
                    </a>
                    <button onclick="window.print()" class="px-4 py-2 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Print</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
        
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 bg-white p-5 rounded-3xl border border-slate-200 shadow-sm text-xs">
            <div>
                <span class="text-slate-400 block font-medium">Status</span>
                <span class="font-bold text-teal-800 uppercase">{{ str_replace('_', ' ', $quotation->status) }}</span>
            </div>
            <div>
                <span class="text-slate-400 block font-medium">Quotation Date</span>
                <span class="font-bold text-slate-900">{{ $quotation->quoted_at?->format('M d, Y') ?? 'Pending Review' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block font-medium">Validity Period</span>
                <span class="font-bold text-slate-900">{{ $quotation->valid_until?->format('M d, Y') ?? '30 Days from issue' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block font-medium">Total Quoted Value</span>
                <span class="font-black text-slate-900">{{ $quotation->subtotal ? number_format($quotation->subtotal, 2) . ' ' . config('env.DEFAULT_CURRENCY', 'NGN') : 'Being calculated' }}</span>
            </div>
        </div>

        <!-- Items Breakdown -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6 space-y-4">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-900">Quotation Breakdown &amp; Equipment Specifications</h2>
            
            <div class="divide-y divide-slate-100 text-xs">
                @foreach($quotation->items as $item)
                    <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <span class="font-bold text-slate-900 text-sm block">{{ $item->product_name }}</span>
                            @if($item->notes)
                                <p class="text-[11px] text-slate-500 mt-0.5">Notes: {{ $item->notes }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <span class="text-slate-500 block">Quantity: <strong>{{ $item->quantity }}</strong></span>
                            @if($item->unit_price)
                                <span class="font-black text-slate-900">{{ number_format($item->subtotal, 2) }} {{ config('env.DEFAULT_CURRENCY', 'NGN') }}</span>
                            @else
                                <span class="text-teal-700 italic text-[11px]">Pricing in preparation</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if($quotation->subtotal)
                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <div class="w-64 space-y-2 text-xs">
                        <div class="flex justify-between font-black text-slate-900 text-sm pt-2 border-t border-slate-200">
                            <span>Quoted Subtotal:</span>
                            <span>{{ number_format($quotation->subtotal, 2) }} {{ config('env.DEFAULT_CURRENCY', 'NGN') }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if($quotation->requirements)
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-2 text-xs">
                <span class="font-bold uppercase tracking-wider text-slate-400 block">Client Clinical Requirements:</span>
                <p class="text-slate-700 leading-relaxed">{{ $quotation->requirements }}</p>
            </div>
        @endif

    </div>

@endsection

