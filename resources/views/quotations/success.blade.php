@extends('layouts.public')

@section('title', 'Quotation request received | MedTech Distributions')

@section('content')

    <div class="shell max-w-2xl py-16 sm:py-24">
        <p class="text-sm font-semibold text-emerald-700">Request received</p>
        <h1 class="mt-1 font-display text-3xl font-bold text-ink">Thank you, we have your request</h1>
        <p class="mt-3 text-[15px] leading-relaxed text-slate-700">We received the equipment list from <b>{{ $quotation->organization_name }}</b>. A confirmation has been sent to {{ $quotation->contact_email }}.</p>

        <dl class="mt-8 divide-y divide-slate-200 border-y border-slate-200 text-[15px]">
            <div class="flex justify-between gap-4 py-3"><dt class="text-slate-500">Reference</dt><dd class="font-mono font-semibold text-ink">{{ $quotation->quotation_number }}</dd></div>
            <div class="flex justify-between gap-4 py-3"><dt class="text-slate-500">Status</dt><dd class="font-semibold text-ink">{{ ucfirst($quotation->status) }}</dd></div>
            <div class="flex justify-between gap-4 py-3"><dt class="text-slate-500">Contact</dt><dd class="text-right text-ink">{{ $quotation->contact_name }}</dd></div>
            <div class="py-3">
                <dt class="mb-2 text-slate-500">Items requested</dt>
                <dd><ul class="space-y-1">@foreach($quotation->items as $item)<li class="flex justify-between gap-4"><span class="text-ink">{{ $item->product_name }}</span><span class="text-slate-500">Qty {{ $item->quantity }}</span></li>@endforeach</ul></dd>
            </div>
        </dl>

        <h2 class="mb-2 mt-10 font-display text-base font-bold text-ink">What happens next</h2>
        <ol class="list-decimal space-y-1.5 pl-5 text-[15px] leading-relaxed text-slate-700">
            <li>Our team checks the configuration and delivery requirements.</li>
            <li>We prepare an itemised quotation with VAT, warranty and delivery terms.</li>
            <li>The quotation is emailed to {{ $quotation->contact_email }}.</li>
        </ol>

        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('products.index') }}" class="btn-primary">Continue browsing</a>
            <a href="{{ route('home') }}" class="btn-quiet">Back to home</a>
            @auth<a href="{{ route('customer.quotations.index') }}" class="btn-quiet">My quotations</a>@endauth
        </div>
    </div>

@endsection
