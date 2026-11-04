@extends('layouts.public')

@section('title', 'My Quotation Proposals — MedEquip Pro')

@section('content')

    <div class="bg-white border-b border-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-slate-500 mb-2 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Home</a>
                <span>/</span>
                <a href="{{ route('dashboard') }}" class="hover:text-teal-600 transition">Portal</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold">Quotations</span>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Quotation &amp; RFQ Proposals</h1>
                    <p class="text-xs text-slate-500 mt-1">Track formal pricing proposals prepared by our biomedical engineering team.</p>
                </div>
                <a href="{{ route('quotations.create') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-teal-600 hover:bg-teal-700 transition shadow-sm">
                    + New Quotation Request
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            @if($quotations->isEmpty())
                <div class="p-12 text-center space-y-3">
                    <p class="text-sm font-bold text-slate-800">No quotation requests found</p>
                    <p class="text-xs text-slate-500">Need pricing on specialized ICU or operating theatre equipment?</p>
                    <a href="{{ route('quotations.create') }}" class="inline-block mt-3 px-5 py-2.5 rounded-xl font-bold text-xs bg-slate-900 text-white hover:bg-teal-700 transition">
                        Submit an RFQ
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs divide-y divide-slate-200">
                        <thead class="bg-slate-50 font-bold text-slate-600 uppercase text-[10px]">
                            <tr>
                                <th class="p-4">RFQ Number</th>
                                <th class="p-4">Submitted Date</th>
                                <th class="p-4">Facility / Org</th>
                                <th class="p-4">Items Count</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 text-right">Quoted Total</th>
                                <th class="p-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-800">
                            @foreach($quotations as $quote)
                                <tr>
                                    <td class="p-4 font-bold text-slate-900 font-mono">{{ $quote->quotation_number }}</td>
                                    <td class="p-4 text-slate-500">{{ $quote->submitted_at?->format('M d, Y') ?? $quote->created_at->format('M d, Y') }}</td>
                                    <td class="p-4 font-semibold">{{ $quote->organization_name }}</td>
                                    <td class="p-4">{{ $quote->items->count() }} items</td>
                                    <td class="p-4">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-teal-50 text-teal-800 border border-teal-200">
                                            {{ str_replace('_', ' ', $quote->status) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-right font-bold text-slate-900">
                                        {{ $quote->subtotal ? number_format($quote->subtotal, 2) . ' ' . config('env.DEFAULT_CURRENCY', 'NGN') : 'Under Review' }}
                                    </td>
                                    <td class="p-4 text-right">
                                        <a href="{{ route('customer.quotations.show', $quote->quotation_number) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-800 transition">
                                            View Proposal
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-slate-100">
                    {{ $quotations->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection

