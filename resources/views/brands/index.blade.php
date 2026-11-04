@extends('layouts.public')

@section('title', 'Authorized Equipment Manufacturers & Brands — MedEquip Pro')
@section('meta_description', 'Discover leading medical technology brands including Philips, GE Healthcare, Mindray, Dräger, and Hamilton Medical.')

@section('content')

    <div class="bg-white border-b border-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-slate-500 mb-2 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Home</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold">Brands</span>
            </nav>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Authorized Equipment Manufacturers</h1>
            <p class="text-sm text-slate-500 mt-1 max-w-2xl">
                We partner with globally recognized medical technology OEMs to supply verified clinical instruments with complete factory warranties and genuine spare parts.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($brands as $brand)
                <div class="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-sm hover:shadow-md hover:border-teal-300 transition duration-200 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center font-black text-slate-700 text-lg mb-4">
                            {{ substr($brand->name, 0, 1) }}
                        </div>
                        <h2 class="text-base font-bold text-slate-900">{{ $brand->name }}</h2>
                        <span class="text-xs text-slate-400 block mt-1">{{ $brand->products_count }} Products in Catalog</span>
                        @if($brand->website)
                            <a href="{{ $brand->website }}" target="_blank" rel="noopener noreferrer" class="text-[11px] text-teal-600 hover:underline mt-2 inline-flex items-center gap-1">
                                <span>Official OEM Website</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <a href="{{ route('products.index', ['brand' => $brand->slug]) }}" class="w-full py-2 px-3 text-center rounded-lg bg-slate-50 hover:bg-teal-50 text-slate-800 hover:text-teal-700 text-xs font-semibold block transition border border-slate-200">
                            View {{ $brand->name }} Products &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection

