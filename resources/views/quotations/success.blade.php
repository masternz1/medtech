@extends('layouts.public')

@section('title', 'Quotation Request Received — MedEquip Pro')

@section('content')

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 shadow-sm text-center space-y-6">
            
            <div class="w-16 h-16 rounded-full bg-teal-100 text-teal-700 mx-auto flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>

            <div class="space-y-2">
                <span class="text-xs uppercase font-bold tracking-wider text-teal-600">Request Confirmed</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Quotation Request Submitted</h1>
                <p class="text-xs sm:text-sm text-slate-600 max-w-md mx-auto">
                    Thank you. We have received your formal equipment request for <strong>{{ $quotation->organization_name }}</strong>.
                </p>
            </div>

            <!-- RFQ Reference Box -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90 text-left space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <div>
                        <span class="text-[10px] text-slate-400 uppercase font-bold block">Quotation Reference #</span>
                        <span class="font-mono text-sm sm:text-base font-black text-slate-900">{{ $quotation->quotation_number }}</span>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-teal-50 text-teal-700 border border-teal-200">
                        {{ ucfirst($quotation->status) }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 text-xs text-slate-600">
                    <div>
                        <span class="text-slate-400 block font-medium">Contact Person:</span>
                        <span class="font-semibold text-slate-900">{{ $quotation->contact_name }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">Official Email:</span>
                        <span class="font-semibold text-slate-900">{{ $quotation->contact_email }}</span>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-200">
                    <span class="text-[10px] text-slate-400 uppercase font-bold block mb-2">Requested Equipment:</span>
                    <ul class="space-y-1.5 text-xs">
                        @foreach($quotation->items as $item)
                            <li class="flex items-center justify-between text-slate-700">
                                <span>{{ $item->product_name }}</span>
                                <span class="font-bold text-slate-900">Qty: {{ $item->quantity }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="text-left bg-teal-50/70 border border-teal-200/80 rounded-2xl p-6 text-xs text-teal-950 space-y-2">
                <h3 class="font-bold text-sm text-teal-900">What Happens Next?</h3>
                <ol class="list-decimal pl-5 space-y-1 text-teal-800">
                    <li>Our biomedical team reviews your equipment configuration and logistics requirements.</li>
                    <li>We prepare an itemized official quotation including VAT, manufacturer warranty, and delivery schedule.</li>
                    <li>The formal document is emailed to <strong>{{ $quotation->contact_email }}</strong> within 24 hours.</li>
                </ol>
            </div>

            <div class="pt-4 flex flex-wrap justify-center gap-4">
                <a href="{{ route('home') }}" class="px-6 py-2.5 rounded-xl font-bold text-xs bg-slate-900 hover:bg-teal-700 text-white transition shadow-sm">
                    Back to Home
                </a>
                <a href="{{ route('products.index') }}" class="px-6 py-2.5 rounded-xl font-bold text-xs bg-slate-100 hover:bg-slate-200 text-slate-800 transition">
                    Continue Browsing
                </a>
                @auth
                    <a href="{{ route('customer.quotations.index') }}" class="px-6 py-2.5 rounded-xl font-bold text-xs border border-teal-600 text-teal-700 hover:bg-teal-50 transition">
                        View in My Quotations
                    </a>
                @endauth
            </div>

        </div>
    </div>

@endsection

