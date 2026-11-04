@extends('layouts.public')

@section('title', 'Medical Equipment Categories — MedEquip Pro')
@section('meta_description', 'Browse all categories of clinical, intensive care, diagnostic and hospital medical equipment.')

@section('content')

    <div class="bg-white border-b border-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-slate-500 mb-2 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Home</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold">Categories</span>
            </nav>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Equipment Categories</h1>
            <p class="text-sm text-slate-500 mt-1 max-w-2xl">
                Browse our comprehensive catalogue organized by clinical specialty, from intensive care ventilators to theatre equipment and daily medical consumables.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($categories as $category)
                <div class="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-sm hover:shadow-md hover:border-teal-300 transition duration-200 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        </div>
                        <h2 class="text-lg font-bold text-slate-900">{{ $category->name }}</h2>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            {{ $category->description }}
                        </p>

                        @if($category->children->isNotEmpty())
                            <div class="mt-4 pt-3 border-t border-slate-100">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Subcategories:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($category->children as $child)
                                        <a href="{{ route('products.index', ['category' => $child->slug]) }}" class="px-2 py-1 text-[11px] bg-slate-50 hover:bg-teal-50 text-slate-700 hover:text-teal-700 rounded-md border border-slate-200 transition">
                                            {{ $child->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-400">{{ $category->products_count }} Products</span>
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="inline-flex items-center text-xs font-bold text-teal-700 hover:text-teal-800">
                            <span>Browse Equipment</span>
                            <span class="ml-1">&rarr;</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection

