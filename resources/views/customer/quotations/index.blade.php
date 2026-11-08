@extends('layouts.public')

@section('title', 'My quotations | MedTech Distributions')

@section('content')

    <div class="page-head">
        <div class="shell flex flex-col justify-between gap-3 py-6 md:flex-row md:items-end">
            <div><h1>My quotations</h1><p class="mt-4 text-sm text-slate-500">Requests you have sent and the quotes we have prepared.</p></div>
            <a href="{{ route('quotations.create') }}" class="btn-primary self-start">New quote request</a>
        </div>
    </div>

    <div class="shell py-6">
        @include('customer._nav')

        @if($quotations->isEmpty())
            <div class="py-14 text-center">
                <p class="font-bold text-ink">No quotation requests yet</p>
                <p class="mt-1 text-sm text-slate-500">Need pricing on ICU or theatre equipment? Send us a list.</p>
                <a href="{{ route('quotations.create') }}" class="btn-primary mt-5">Request a quote</a>
            </div>
        @else
            <div class="mt-6 overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead><tr class="border-b border-slate-300 text-slate-500">
                        <th class="py-2 pr-4 font-semibold">Reference</th><th class="py-2 pr-4 font-semibold">Submitted</th><th class="py-2 pr-4 font-semibold">Organisation</th><th class="py-2 pr-4 font-semibold">Items</th><th class="py-2 pr-4 font-semibold">Status</th><th class="py-2 pr-4 text-right font-semibold">Quoted total</th><th class="py-2"></th>
                    </tr></thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($quotations as $quote)
                            <tr>
                                <td class="py-3 pr-4 font-semibold text-ink">{{ $quote->quotation_number }}</td>
                                <td class="py-3 pr-4 text-slate-600">{{ ($quote->submitted_at ?? $quote->created_at)->format('j M Y') }}</td>
                                <td class="py-3 pr-4 text-slate-600">{{ $quote->organization_name }}</td>
                                <td class="py-3 pr-4 text-slate-600">{{ $quote->items->count() }}</td>
                                <td class="py-3 pr-4 capitalize">{{ str_replace('_', ' ', $quote->status) }}</td>
                                <td class="py-3 pr-4 text-right font-semibold text-ink">{{ $quote->subtotal ? number_format($quote->subtotal, 2) . ' ' . config('env.DEFAULT_CURRENCY', 'NGN') : 'In review' }}</td>
                                <td class="py-3 text-right"><a href="{{ route('customer.quotations.show', $quote->quotation_number) }}" class="font-semibold text-brand-700 hover:underline">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $quotations->links() }}</div>
        @endif
    </div>

@endsection
