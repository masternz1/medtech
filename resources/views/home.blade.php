@extends('layouts.public')

@section('title', 'MedEquip Pro — Professional Medical Equipment & Hospital Supplies')

@section('content')

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-slate-950 via-slate-900 to-teal-950 text-white overflow-hidden py-20 lg:py-28">
        <!-- Ambient background glows -->
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Hero Left Content -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-teal-500/10 border border-teal-500/30 text-teal-300 text-xs font-semibold">
                        <span class="w-2 h-2 rounded-full bg-teal-400 animate-ping"></span>
                        Trusted Clinical & Hospital Systems Partner
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight">
                        Precision Medical Technology for <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-400 via-cyan-300 to-sky-300">Modern Healthcare</span>
                    </h1>

                    <p class="text-slate-300 text-base sm:text-lg leading-relaxed max-w-2xl">
                        {{ $siteSettings['hero_subtitle'] ?? 'We equip intensive care units, operating theatres, diagnostic centres and clinics with premium ventilators, vital sign monitors, oxygen generators and surgical instruments backed by certified biomedical engineers.' }}
                    </p>

                    <!-- Hero Search & Action -->
                    <div class="pt-2 flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl font-bold text-sm text-slate-950 bg-teal-400 hover:bg-teal-300 transition shadow-lg shadow-teal-500/20">
                            <span>Browse Equipment Catalog</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                        <a href="{{ route('quotations.create') }}" class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl font-bold text-sm text-white bg-slate-800/80 hover:bg-slate-700/80 border border-slate-700 transition">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Request Custom Quotation</span>
                        </a>
                    </div>

                    <!-- Key Trust Stats -->
                    <div class="pt-8 border-t border-slate-800/80 grid grid-cols-2 sm:grid-cols-4 gap-6">
                        <div>
                            <div class="text-2xl sm:text-3xl font-black text-white">500+</div>
                            <div class="text-xs text-slate-400 font-medium">Devices Installed</div>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-black text-teal-400">100%</div>
                            <div class="text-xs text-slate-400 font-medium">Genuine Equipment</div>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-black text-white">12+</div>
                            <div class="text-xs text-slate-400 font-medium">Global OEM Brands</div>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-black text-teal-400">24/7</div>
                            <div class="text-xs text-slate-400 font-medium">Engineer Hotline</div>
                        </div>
                    </div>
                </div>

                <!-- Hero Right Card / Featured Highlights -->
                <div class="lg:col-span-5">
                    <div class="relative bg-slate-800/60 backdrop-blur-md rounded-2xl p-6 border border-slate-700/60 shadow-2xl">
                        <div class="flex items-center justify-between pb-4 border-b border-slate-700/60">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
                                <span class="text-xs font-semibold uppercase tracking-wider text-slate-300">Featured Critical Care Unit</span>
                            </div>
                            <span class="text-xs px-2.5 py-0.5 rounded-full bg-teal-500/20 text-teal-300 font-medium">In Stock</span>
                        </div>

                        <div class="py-6 space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-xl bg-slate-900 flex items-center justify-center text-teal-400 shrink-0">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                                <div>
                                    <span class="text-xs text-teal-400 font-semibold uppercase">Dräger &bull; Critical Care</span>
                                    <h3 class="text-lg font-bold text-white leading-snug">Dräger Evita V800 ICU Ventilator</h3>
                                    <p class="text-xs text-slate-400">Automated SmartCare/PS weaning platform with NeoFlow.</p>
                                </div>
                            </div>

                            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-700/40 space-y-2 text-xs">
                                <div class="flex justify-between text-slate-300">
                                    <span>Tidal Volume Range:</span>
                                    <span class="font-semibold text-white">2–3000 mL</span>
                                </div>
                                <div class="flex justify-between text-slate-300">
                                    <span>Patient Coverage:</span>
                                    <span class="font-semibold text-white">Neonatal to Adult</span>
                                </div>
                                <div class="flex justify-between text-slate-300">
                                    <span>Warranty:</span>
                                    <span class="font-semibold text-teal-300">2-Year Full OEM Warranty</span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-700/60 flex items-center justify-between">
                            <div>
                                <span class="text-[11px] text-slate-400 block">Institutional Pricing</span>
                                <span class="text-lg font-black text-white">Request Quotation</span>
                            </div>
                            <a href="{{ route('quotations.create', ['product' => 'drager-evita-v800-ventilator']) }}" class="px-4 py-2 rounded-lg bg-teal-500 hover:bg-teal-400 text-slate-950 text-xs font-bold transition">
                                Request Specs &amp; Quote
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Equipment Categories Section -->
    <section class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-teal-600">Product Categories</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">
                        Explore by Medical Specialty
                    </h2>
                </div>
                <a href="{{ route('categories.index') }}" class="text-sm font-semibold text-teal-700 hover:text-teal-800 inline-flex items-center gap-1">
                    <span>View all categories</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($featuredCategories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="group p-5 bg-slate-50 hover:bg-teal-50/50 rounded-2xl border border-slate-200/80 hover:border-teal-300 transition-all duration-200 shadow-sm hover:shadow-md flex flex-col justify-between">
                        <div class="w-12 h-12 rounded-xl bg-white group-hover:bg-teal-600 group-hover:text-white text-teal-700 flex items-center justify-center mb-4 transition-colors shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm text-slate-900 group-hover:text-teal-700 transition">
                                {{ $category->name }}
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                                {{ $category->description }}
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-200/60 flex items-center justify-between text-xs text-slate-500">
                            <span>{{ $category->products_count }} Products</span>
                            <span class="group-hover:translate-x-1 transition-transform text-teal-600 font-bold">&rarr;</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products Showcase -->
    <section class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-teal-600">Clinical Selection</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">
                        Featured Medical Equipment
                    </h2>
                </div>
                <a href="{{ route('products.index') }}" class="text-sm font-semibold text-teal-700 hover:text-teal-800 inline-flex items-center gap-1">
                    <span>View all equipment catalog</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProducts as $product)
                    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between overflow-hidden group">
                        
                        <!-- Top Image & Badges -->
                        <div class="relative bg-slate-100/70 p-6 flex items-center justify-center h-48 overflow-hidden">
                            @if($product->primary_image_url)
                                <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" class="max-h-36 max-w-full object-contain group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-20 h-20 rounded-2xl bg-slate-200 text-slate-400 flex items-center justify-center">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
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

                        <!-- Card Body -->
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="text-[11px] font-medium text-slate-400 block mb-1">
                                    {{ $product->category?->name ?? 'Medical Device' }} &bull; SKU: {{ $product->sku }}
                                </span>
                                <a href="{{ route('products.show', $product->slug) }}" class="font-bold text-slate-900 group-hover:text-teal-700 transition line-clamp-2 leading-snug">
                                    {{ $product->name }}
                                </a>
                                <p class="text-xs text-slate-500 mt-2 line-clamp-2">
                                    {{ $product->short_description }}
                                </p>
                            </div>

                            <!-- Price & Action Button -->
                            <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-slate-400 block">Price</span>
                                    <span class="text-sm font-extrabold text-slate-900">
                                        {{ $product->formatted_price }}
                                    </span>
                                </div>

                                <div>
                                    @if($product->isQuoteOnly())
                                        <a href="{{ route('quotations.create', ['product' => $product->slug]) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-teal-50 text-teal-700 hover:bg-teal-100 border border-teal-200 transition">
                                            Quote
                                        </a>
                                    @else
                                        <form action="{{ route('cart.add') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-900 hover:bg-teal-700 text-white transition shadow-sm">
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
        </div>
    </section>

    <!-- Why Choose Us / Trust Pillars -->
    <section class="py-16 bg-white border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-xs font-bold uppercase tracking-wider text-teal-600">Medical Device Integrity</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">
                    Why Healthcare Facilities Trust MedEquip Pro
                </h2>
                <p class="text-sm text-slate-500 mt-2">
                    We deliver reliable medical technology that doctors and biomedical teams depend upon in critical clinical scenarios.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base">Certified &amp; Genuine</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        100% genuine medical equipment sourced straight from authorized global manufacturers with complete regulatory certificates.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-cyan-100 text-cyan-700 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base">Biomedical Engineering</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        In-house factory-trained biomedical engineers handle professional installation, calibration, and clinical staff operation training.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base">Rapid Nationwide Delivery</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Fast delivery across all 36 states with specialized secure packaging to guarantee safety of delicate diagnostic sensors and optics.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base">Warranty &amp; Spare Parts</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Comprehensive manufacturer warranty plus ready-to-dispatch inventory of spare parts and replacement breathing circuits.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Overview -->
    <section class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-teal-600">Full Lifecycle Support</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">
                        Our Specialized Medical Services
                    </h2>
                </div>
                <a href="{{ route('services.index') }}" class="text-sm font-semibold text-teal-700 hover:text-teal-800 inline-flex items-center gap-1">
                    <span>View all services</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($services as $service)
                    <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:border-teal-300 transition space-y-3">
                        <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base">{{ $service->title }}</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            {{ $service->description }}
                        </p>
                        <a href="{{ route('services.show', $service->slug) }}" class="inline-flex items-center text-xs font-semibold text-teal-600 hover:text-teal-700 mt-2">
                            <span>Learn more</span>
                            <span class="ml-1">&rarr;</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Trusted Global Brands -->
    <section class="py-14 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Authorized Distribution Partners</span>
                <h3 class="text-lg font-bold text-slate-800 mt-1">Global Medical Device Brands</h3>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-4 sm:gap-6">
                @foreach($featuredBrands as $brand)
                    <a href="{{ route('products.index', ['brand' => $brand->slug]) }}" class="px-5 py-3 rounded-xl bg-slate-50 hover:bg-teal-50/60 border border-slate-200/80 hover:border-teal-300 transition text-center group">
                        <span class="font-bold text-xs sm:text-sm text-slate-700 group-hover:text-teal-800 transition">
                            {{ $brand->name }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs font-bold uppercase tracking-wider text-teal-400">Clinical Reviews</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight mt-1">
                    What Healthcare Leaders Say
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($testimonials as $t)
                    <div class="bg-slate-800/60 p-6 rounded-2xl border border-slate-700/60 flex flex-col justify-between space-y-4">
                        <p class="text-xs text-slate-300 leading-relaxed italic">
                            &ldquo;{{ $t->content }}&rdquo;
                        </p>
                        <div class="pt-4 border-t border-slate-700/60">
                            <h4 class="font-bold text-sm text-white">{{ $t->name }}</h4>
                            <p class="text-[11px] text-teal-400 font-medium">{{ $t->title }}</p>
                            <p class="text-[10px] text-slate-400">{{ $t->organization }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Institutional CTA Section -->
    <section class="py-16 bg-gradient-to-r from-teal-700 to-cyan-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-2xl space-y-2">
                <span class="text-xs uppercase font-extrabold tracking-wider text-teal-200">Institutional Procurement</span>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight">
                    Equipping a New Hospital or ICU Facility?
                </h2>
                <p class="text-sm text-teal-50 leading-relaxed">
                    Our biomedical engineering team can prepare a full equipment bill of quantities, clinical floor plan consultation, and formal tender quote within 24 hours.
                </p>
            </div>
            <div class="flex items-center gap-4 shrink-0">
                <a href="{{ route('quotations.create') }}" class="px-6 py-3.5 rounded-xl font-bold text-sm text-teal-950 bg-white hover:bg-teal-50 transition shadow-lg">
                    Request Formal Quotation
                </a>
                <a href="{{ route('contact') }}" class="px-6 py-3.5 rounded-xl font-bold text-sm text-white bg-teal-800/60 hover:bg-teal-800 border border-white/20 transition">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

@endsection

