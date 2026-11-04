@extends('layouts.public')

@section('title', 'Equipment Catalog — MedEquip Pro')
@section('meta_description', 'Browse our extensive catalog of certified medical equipment, ICU ventilators, patient monitors, oxygen concentrators, hospital beds, and surgical tools.')

@section('content')

    <!-- Breadcrumb & Header Bar -->
    <div class="bg-white border-b border-slate-200 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-slate-500 mb-2 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Home</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold">Equipment Catalog</span>
                @if($currentCategory)
                    <span>/</span>
                    <span class="text-teal-600 font-semibold">{{ $currentCategory->name }}</span>
                @endif
                @if($currentBrand)
                    <span>/</span>
                    <span class="text-teal-600 font-semibold">{{ $currentBrand->name }}</span>
                @endif
            </nav>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        @if($currentCategory)
                            {{ $currentCategory->name }}
                        @elseif($currentBrand)
                            {{ $currentBrand->name }} Equipment
                        @else
                            Medical Equipment Catalog
                        @endif
                    </h1>
                    <p class="text-xs text-slate-500 mt-1">
                        @if($currentCategory)
                            {{ $currentCategory->description }}
                        @else
                            Explore certified clinical systems, intensive care ventilators, patient monitors, and hospital supplies.
                        @endif
                    </p>
                </div>

                <a href="{{ route('quotations.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold rounded-lg bg-teal-600 hover:bg-teal-700 text-white transition self-start md:self-auto shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Request Custom Quote</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Catalog Body -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Filters Sidebar -->
            <aside class="space-y-6">
                <form action="{{ route('products.index') }}" method="GET" id="filter-form" class="space-y-6">
                    
                    <!-- Search Filter -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-sm space-y-3">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">Keyword Search</label>
                        <div class="relative">
                            <input
                                type="text"
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="Model, SKU, ventilator..."
                                class="w-full pl-8 pr-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                            />
                            <svg class="w-4 h-4 absolute left-2.5 top-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-sm space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Categories</label>
                            @if(request('category'))
                                <a href="{{ request()->fullUrlWithQuery(['category' => null, 'page' => 1]) }}" class="text-[11px] text-teal-600 hover:underline">Clear</a>
                            @endif
                        </div>
                        <div class="space-y-1.5 max-h-64 overflow-y-auto pr-1 text-xs">
                            <a href="{{ request()->fullUrlWithQuery(['category' => null, 'page' => 1]) }}" class="flex items-center justify-between px-2 py-1.5 rounded-lg {{ !request('category') ? 'bg-teal-50 text-teal-700 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                                <span>All Categories</span>
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ request()->fullUrlWithQuery(['category' => $cat->slug, 'page' => 1]) }}" class="flex items-center justify-between px-2 py-1.5 rounded-lg {{ request('category') === $cat->slug ? 'bg-teal-50 text-teal-700 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                                    <span class="truncate pr-2">{{ $cat->name }}</span>
                                    <span class="text-[10px] text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded">{{ $cat->products_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Brand Filter -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-sm space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Brand / OEM</label>
                            @if(request('brand'))
                                <a href="{{ request()->fullUrlWithQuery(['brand' => null, 'page' => 1]) }}" class="text-[11px] text-teal-600 hover:underline">Clear</a>
                            @endif
                        </div>
                        <div class="space-y-1.5 max-h-60 overflow-y-auto pr-1 text-xs">
                            <a href="{{ request()->fullUrlWithQuery(['brand' => null, 'page' => 1]) }}" class="flex items-center justify-between px-2 py-1.5 rounded-lg {{ !request('brand') ? 'bg-teal-50 text-teal-700 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                                <span>All Brands</span>
                            </a>
                            @foreach($brands as $brand)
                                <a href="{{ request()->fullUrlWithQuery(['brand' => $brand->slug, 'page' => 1]) }}" class="flex items-center justify-between px-2 py-1.5 rounded-lg {{ request('brand') === $brand->slug ? 'bg-teal-50 text-teal-700 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                                    <span class="truncate pr-2">{{ $brand->name }}</span>
                                    <span class="text-[10px] text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded">{{ $brand->products_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Pricing Type & In Stock Checkboxes -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-sm space-y-3 text-xs">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">Availability &amp; Quote</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }} onchange="document.getElementById('filter-form').submit()" class="rounded text-teal-600 focus:ring-teal-500 text-xs">
                                <span class="text-slate-700">In Stock Units Only</span>
                            </label>
                        </div>

                        <div class="pt-3 border-t border-slate-100 space-y-1.5">
                            <span class="block text-[11px] font-semibold text-slate-500 uppercase">Pricing Mode</span>
                            <div class="space-y-1">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="pricing_type" value="" {{ !request('pricing_type') ? 'checked' : '' }} onchange="document.getElementById('filter-form').submit()" class="text-teal-600 focus:ring-teal-500">
                                    <span>All Equipment</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="pricing_type" value="fixed" {{ request('pricing_type') === 'fixed' ? 'checked' : '' }} onchange="document.getElementById('filter-form').submit()" class="text-teal-600 focus:ring-teal-500">
                                    <span>Instant Purchase (Fixed)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="pricing_type" value="quote_preferred" {{ request('pricing_type') === 'quote_preferred' ? 'checked' : '' }} onchange="document.getElementById('filter-form').submit()" class="text-teal-600 focus:ring-teal-500">
                                    <span>Quote Preferred (ICU Systems)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2.5 px-4 bg-slate-900 hover:bg-teal-700 text-white font-semibold text-xs rounded-xl transition shadow-sm">
                        Apply Filters
                    </button>

                    @if(request()->anyFilled(['q', 'category', 'brand', 'in_stock', 'pricing_type', 'min_price', 'max_price']))
                        <a href="{{ route('products.index') }}" class="block text-center text-xs text-rose-600 hover:underline">
                            Reset All Filters
                        </a>
                    @endif
                </form>
            </aside>

            <!-- Products Listing Main Column -->
            <div class="lg:col-span-3 space-y-6">
                
                <!-- Toolbar with count & sort -->
                <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-xs text-slate-500">
                        Showing <span class="font-bold text-slate-800">{{ $products->firstItem() ?? 0 }}</span> to <span class="font-bold text-slate-800">{{ $products->lastItem() ?? 0 }}</span> of <span class="font-bold text-slate-800">{{ $products->total() }}</span> equipment items
                    </div>

                    <!-- Sort Dropdown -->
                    <div class="flex items-center gap-2 text-xs">
                        <label for="sort-select" class="text-slate-500 shrink-0 font-medium">Sort by:</label>
                        <select
                            id="sort-select"
                            onchange="location = this.value"
                            class="py-1.5 pl-3 pr-8 text-xs bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                        >
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" {{ $sort === 'newest' ? 'selected' : '' }}>Newest Equipment</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'featured']) }}" {{ $sort === 'featured' ? 'selected' : '' }}>Featured First</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ $sort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}" {{ $sort === 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                        </select>
                    </div>
                </div>

                <!-- Products Grid -->
                @if($products->isEmpty())
                    <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center space-y-4">
                        <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">No medical equipment matches your search</h3>
                        <p class="text-xs text-slate-500 max-w-md mx-auto">
                            Try adjusting your filters or search keywords. If you are seeking specialized hospital equipment not listed, our procurement team can source it directly.
                        </p>
                        <div class="pt-2 flex justify-center gap-3">
                            <a href="{{ route('products.index') }}" class="px-4 py-2 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-lg transition">
                                Clear Filters
                            </a>
                            <a href="{{ route('quotations.create') }}" class="px-4 py-2 text-xs font-semibold bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition">
                                Request Custom Sourcing
                            </a>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between overflow-hidden group">
                                
                                <!-- Card Image -->
                                <div class="relative bg-slate-100/70 p-6 flex items-center justify-center h-48 overflow-hidden">
                                    @if($product->primary_image_url)
                                        <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" class="max-h-36 max-w-full object-contain group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-16 h-16 rounded-xl bg-slate-200 text-slate-400 flex items-center justify-center">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                    @endif

                                    <div class="absolute top-3 left-3 flex flex-col gap-1">
                                        @if($product->is_new)
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-teal-600 text-white">New</span>
                                        @endif
                                        @if($product->brand)
                                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-white text-slate-700 shadow-sm border border-slate-200">{{ $product->brand->name }}</span>
                                        @endif
                                    </div>

                                    <div class="absolute top-3 right-3">
                                        @if($product->isInStock())
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">In Stock</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-medium bg-slate-100 text-slate-600">On Order</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Card Details -->
                                <div class="p-5 flex-1 flex flex-col justify-between">
                                    <div>
                                        <span class="text-[11px] font-medium text-slate-400 block mb-1">
                                            {{ $product->category?->name ?? 'Clinical Device' }} &bull; SKU: {{ $product->sku }}
                                        </span>
                                        <a href="{{ route('products.show', $product->slug) }}" class="font-bold text-slate-900 group-hover:text-teal-700 transition line-clamp-2 leading-snug">
                                            {{ $product->name }}
                                        </a>
                                        <p class="text-xs text-slate-500 mt-2 line-clamp-2">
                                            {{ $product->short_description }}
                                        </p>
                                    </div>

                                    <!-- Price & Actions -->
                                    <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                                        <div>
                                            <span class="text-[10px] text-slate-400 block">Unit Price</span>
                                            <span class="text-sm font-extrabold text-slate-900">
                                                {{ $product->formatted_price }}
                                            </span>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('products.show', $product->slug) }}" class="p-1.5 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition" title="View Specifications">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            
                                            @if($product->isQuoteOnly())
                                                <a href="{{ route('quotations.create', ['product' => $product->slug]) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-teal-50 text-teal-700 hover:bg-teal-100 border border-teal-200 transition">
                                                    Quote
                                                </a>
                                            @else
                                                <form action="{{ route('cart.add') }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-900 hover:bg-teal-700 text-white transition shadow-sm">
                                                        Add to Cart
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="pt-6">
                        {{ $products->links() }}
                    </div>
                @endif

            </div>

        </div>
    </div>

@endsection

