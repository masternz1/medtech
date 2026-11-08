@extends('layouts.public')

@section('title', 'Quotation ' . $quotation->quotation_number . ' | MedTech Distributions')

@section('content')

    <div class="page-head">
        <div class="shell flex flex-col justify-between gap-3 py-6 md:flex-row md:items-end">
            <div>
                <nav class="crumbs flex gap-x-2" aria-label="Breadcrumb"><a href="{{ route('customer.quotations.index') }}">Quotations</a><span>/</span><span class="text-slate-700">{{ $quotation->quotation_number }}</span></nav>
                <h1 class="mt-5">Quotation {{ $quotation->quotation_number }}</h1>
                <p class="mt-4 text-sm text-slate-500">Submitted {{ ($quotation->submitted_at ?? $quotation->created_at)->format('j M Y') }} for {{ $quotation->organization_name }}</p>
            </div>
            <div class="flex gap-3 print:hidden">
                <a href="{{ route('quotations.pdf', $quotation->quotation_number) }}" target="_blank" class="btn-outline">Download PDF</a>
                <button onclick="window.print()" class="btn-quiet">Print</button>
            </div>
        </div>
    </div>

    <div class="shell max-w-4xl py-14 sm:py-20">
        <dl class="grid grid-cols-2 gap-y-4 border-y border-slate-200 py-5 text-sm md:grid-cols-4">
            <div><dt class="text-slate-500">Status</dt><dd class="mt-0.5 font-semibold capitalize text-ink">{{ str_replace('_', ' ', $quotation->status) }}</dd></div>
            <div><dt class="text-slate-500">Quoted on</dt><dd class="mt-0.5 font-semibold text-ink">{{ $quotation->quoted_at?->format('j M Y') ?? 'Awaiting review' }}</dd></div>
            <div><dt class="text-slate-500">Valid until</dt><dd class="mt-0.5 font-semibold text-ink">{{ $quotation->valid_until?->format('j M Y') ?? 'Stated on the quote' }}</dd></div>
            <div><dt class="text-slate-500">Quoted total</dt><dd class="mt-0.5 font-display text-lg font-bold text-ink">{{ $quotation->subtotal ? number_format($quotation->subtotal, 2) . ' ' . config('env.DEFAULT_CURRENCY', 'NGN') : 'Being prepared' }}</dd></div>
        </dl>

        <h2 class="sec-title mb-3 mt-10">Items</h2>
        <ul class="divide-y divide-slate-200 border-y border-slate-200 text-sm">
            @foreach($quotation->items as $item)
                <li class="flex justify-between gap-4 py-3">
                    <span>
                        <b class="block text-ink">{{ $item->product_name }}</b>
                        @if($item->notes)<span class="text-slate-500">{{ $item->notes }}</span>@endif
                    </span>
                    <span class="shrink-0 text-right">
                        <span class="block text-slate-500">Qty {{ $item->quantity }}</span>
                        <b class="text-ink">{{ $item->unit_price ? number_format($item->subtotal, 2) . ' ' . config('env.DEFAULT_CURRENCY', 'NGN') : 'Price to follow' }}</b>
                    </span>
                </li>
            @endforeach
        </ul>

        @if($quotation->subtotal)
            <p class="mt-4 text-right text-[15px] text-slate-600">Subtotal <b class="ml-2 font-display text-lg text-ink">{{ number_format($quotation->subtotal, 2) }} {{ config('env.DEFAULT_CURRENCY', 'NGN') }}</b></p>
        @endif

        @if($quotation->requirements)
            <h2 class="mb-2 mt-10 font-display text-base font-bold text-ink">Your requirements</h2>
            <p class="whitespace-pre-line text-[15px] leading-relaxed text-slate-700">{{ $quotation->requirements }}</p>
        @endif
    </div>

@endsection
