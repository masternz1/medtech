@extends('layouts.public')

@section('title', $product->meta_title ?? ($product->name . ' — MedEquip Pro'))
@section('meta_description', $product->meta_description ?? $product->short_description)

@section('content')

    <!-- Breadcrumb -->
    <div class="bg-white border-b border-slate-200 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-slate-500 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Home</a>
                <span>/</span>
                <a href="{{ route('products.index') }}" class="hover:text-teal-600 transition">Catalog</a>
                @if($product->category)
                    <span>/</span>
                    <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-teal-600 transition">{{ $product->category->name }}</a>
                @endif
                <span>/</span>
                <span class="text-slate-900 font-semibold truncate">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Product Details Main Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ activeTab: 'specs' }">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Product Images Gallery (Col 5) -->
            <div class="lg:col-span-5 space-y-4" x-data="{ currentImage: '{{ $product->primary_image_url }}' }">
                <div class="bg-white rounded-2xl border border-slate-200 p-8 flex items-center justify-center min-h-[360px] relative shadow-sm">
                    <template x-if="currentImage">
                        <img :src="currentImage" alt="{{ $product->name }}" class="max-h-80 max-w-full object-contain">
                    </template>
                    <template x-if="!currentImage">
                        <div class="text-center text-slate-400 space-y-2">
                            <svg class="w-16 h-16 mx-auto text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span class="text-xs">Clinical Equipment Photo</span>
                        </div>
                    </template>

                    <div class="absolute top-4 left-4 flex flex-col gap-1.5">
                        @if($product->is_new)
                            <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-teal-600 text-white shadow-sm">New Model</span>
                        @endif
                        @if($product->brand)
                            <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-900 text-white shadow-sm">{{ $product->brand->name }}</span>
                        @endif
                    </div>
                </div>

                <!-- Thumbnail strip if multiple images -->
                @if($product->images->count() > 1)
                    <div class="flex items-center gap-3 overflow-x-auto pb-2">
                        @foreach($product->images as $img)
                            <button
                                @click="currentImage = '{{ $img->path }}'"
                                class="w-16 h-16 rounded-xl border p-2 bg-white flex items-center justify-center shrink-0 transition"
                                :class="{ 'border-teal-600 ring-2 ring-teal-500/20': currentImage === '{{ $img->path }}', 'border-slate-200': currentImage !== '{{ $img->path }}' }"
                            >
                                <img src="{{ $img->path }}" alt="Thumbnail" class="max-h-full max-w-full object-contain">
                            </button>
                        @endforeach
                    </div>
                @endif

                <!-- Clinical Quality Trust Badges -->
                <div class="bg-slate-50 rounded-2xl border border-slate-200/80 p-5 space-y-3 text-xs">
                    <div class="flex items-center gap-3 text-slate-700">
                        <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span><strong>NAFDAC / ISO Compliant:</strong> Certified authentic clinical device.</span>
                    </div>
                    <div class="flex items-center gap-3 text-slate-700">
                        <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span><strong>Installation &amp; Calibration:</strong> Optional certified biomedical engineer handover.</span>
                    </div>
                    <div class="flex items-center gap-3 text-slate-700">
                        <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span><strong>Warranty Support:</strong> {{ $product->warranty_info ?? 'Standard 1-year manufacturer warranty.' }}</span>
                    </div>
                </div>
            </div>

            <!-- Product Summary & Purchase Options (Col 7) -->
            <div class="lg:col-span-7 space-y-6">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        @if($product->category)
                            <span class="text-xs font-semibold text-teal-700 bg-teal-50 px-2.5 py-0.5 rounded-full border border-teal-200">
                                {{ $product->category->name }}
                            </span>
                        @endif
                        <span class="text-xs text-slate-400">SKU: <span class="font-mono text-slate-600 font-semibold">{{ $product->sku }}</span></span>
                        @if($product->model_number)
                            <span class="text-xs text-slate-400">Model: <span class="text-slate-600 font-semibold">{{ $product->model_number }}</span></span>
                        @endif
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                        {{ $product->name }}
                    </h1>
                </div>

                <!-- Price & Stock Status Box -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
                    <div class="flex items-baseline justify-between gap-4">
                        <div>
                            <span class="text-xs text-slate-400 block font-medium">Pricing</span>
                            <span class="text-3xl font-black text-slate-900">
                                {{ $product->formatted_price }}
                            </span>
                            @if($product->compare_price && $product->compare_price > $product->price)
                                <span class="ml-2 text-sm text-slate-400 line-through">
                                    {{ number_format($product->compare_price, 2) }} {{ config('env.DEFAULT_CURRENCY', 'NGN') }}
                                </span>
                            @endif
                        </div>

                        <div>
                            @if($product->isInStock())
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    In Stock ({{ $product->available_stock }} available)
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    Available On Lead Time / Backorder
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Short Description -->
                    <p class="text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                        {{ $product->short_description }}
                    </p>

                    <!-- Add to Cart or Quote Action -->
                    <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        @if(!$product->isQuoteOnly())
                            <!-- Quantity Form + Cart -->
                            <form action="{{ route('cart.add') }}" method="POST" class="flex items-center gap-3 flex-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <div class="w-24 shrink-0">
                                    <label for="quantity" class="sr-only">Quantity</label>
                                    <input
                                        type="number"
                                        id="quantity"
                                        name="quantity"
                                        value="1"
                                        min="1"
                                        max="{{ max(1, $product->available_stock) }}"
                                        class="w-full text-center py-2.5 px-3 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500"
                                    />
                                </div>

                                <button type="submit" class="flex-1 py-3 px-6 rounded-xl font-bold text-sm text-white bg-slate-900 hover:bg-teal-700 transition shadow-md flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    <span>Add to Cart</span>
                                </button>
                            </form>
                        @endif

                        <!-- Request Quote Button (Always available for institutions) -->
                        <a href="{{ route('quotations.create', ['product' => $product->slug]) }}" class="py-3 px-6 rounded-xl font-bold text-sm text-teal-800 bg-teal-50 hover:bg-teal-100 border border-teal-200 transition text-center flex items-center justify-center gap-2 shadow-sm">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Request Formal RFQ</span>
                        </a>
                    </div>
                </div>

                <!-- Contact Medical Consultant Quick Link -->
                <div class="bg-teal-50/60 rounded-2xl border border-teal-100 p-4 flex items-center justify-between text-xs">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-teal-600 text-white flex items-center justify-center font-bold">?</div>
                        <div>
                            <span class="font-bold text-slate-900 block">Questions about clinical configuration?</span>
                            <span class="text-slate-500">Our biomedical team is ready to assist.</span>
                        </div>
                    </div>
                    <a href="{{ route('contact', ['product_id' => $product->id]) }}" class="font-semibold text-teal-700 hover:underline">
                        Ask Specialist &rarr;
                    </a>
                </div>

            </div>

        </div>

        <!-- Specifications & Documentation Tabs -->
        <div class="mt-14 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <!-- Tab Headers -->
            <div class="flex border-b border-slate-200 bg-slate-50/70 overflow-x-auto">
                <button
                    @click="activeTab = 'specs'"
                    class="py-4 px-6 text-xs sm:text-sm font-bold border-b-2 transition whitespace-nowrap"
                    :class="{ 'border-teal-600 text-teal-700 bg-white': activeTab === 'specs', 'border-transparent text-slate-500 hover:text-slate-800': activeTab !== 'specs' }"
                >
                    Technical Specifications
                </button>
                <button
                    @click="activeTab = 'description'"
                    class="py-4 px-6 text-xs sm:text-sm font-bold border-b-2 transition whitespace-nowrap"
                    :class="{ 'border-teal-600 text-teal-700 bg-white': activeTab === 'description', 'border-transparent text-slate-500 hover:text-slate-800': activeTab !== 'description' }"
                >
                    Full Clinical Overview
                </button>
                <button
                    @click="activeTab = 'features'"
                    class="py-4 px-6 text-xs sm:text-sm font-bold border-b-2 transition whitespace-nowrap"
                    :class="{ 'border-teal-600 text-teal-700 bg-white': activeTab === 'features', 'border-transparent text-slate-500 hover:text-slate-800': activeTab !== 'features' }"
                >
                    Key Features
                </button>
                <button
                    @click="activeTab = 'warranty'"
                    class="py-4 px-6 text-xs sm:text-sm font-bold border-b-2 transition whitespace-nowrap"
                    :class="{ 'border-teal-600 text-teal-700 bg-white': activeTab === 'warranty', 'border-transparent text-slate-500 hover:text-slate-800': activeTab !== 'warranty' }"
                >
                    Warranty &amp; Service
                </button>
            </div>

            <!-- Tab 1: Technical Specifications -->
            <div x-show="activeTab === 'specs'" class="p-6 sm:p-8 space-y-6">
                @if($specificationsByGroup->isNotEmpty())
                    @foreach($specificationsByGroup as $groupName => $specs)
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-teal-700 mb-3">{{ $groupName }}</h3>
                            <div class="border border-slate-200 rounded-xl overflow-hidden divide-y divide-slate-200 text-xs">
                                @foreach($specs as $s)
                                    <div class="grid grid-cols-1 sm:grid-cols-3 p-3 {{ $loop->even ? 'bg-slate-50' : 'bg-white' }}">
                                        <span class="font-semibold text-slate-700">{{ $s->label }}</span>
                                        <span class="sm:col-span-2 text-slate-600 mt-1 sm:mt-0">{{ $s->value }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-xs text-slate-500 italic">No formal specification sheet published yet. Please contact us for the official manufacturer datasheet.</p>
                @endif
            </div>

            <!-- Tab 2: Full Clinical Description -->
            <div x-show="activeTab === 'description'" class="p-6 sm:p-8 space-y-4" style="display: none;">
                <div class="prose prose-sm max-w-none text-slate-700 text-xs sm:text-sm leading-relaxed whitespace-pre-line">
                    {{ $product->description ?? $product->short_description }}
                </div>
            </div>

            <!-- Tab 3: Key Features -->
            <div x-show="activeTab === 'features'" class="p-6 sm:p-8 space-y-3" style="display: none;">
                @if($product->features)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                        @foreach(explode("\n", $product->features) as $feature)
                            @if(trim($feature))
                                <div class="flex items-start gap-2.5 p-3 rounded-xl bg-slate-50 border border-slate-200/80">
                                    <svg class="w-4 h-4 text-teal-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span class="text-slate-800 font-medium">{{ trim($feature) }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-500">Contact us for feature list.</p>
                @endif
            </div>

            <!-- Tab 4: Warranty & Service -->
            <div x-show="activeTab === 'warranty'" class="p-6 sm:p-8 space-y-4" style="display: none;">
                <div class="max-w-2xl space-y-4 text-xs sm:text-sm text-slate-600">
                    <div class="p-4 rounded-xl bg-teal-50 border border-teal-200 text-teal-900">
                        <h4 class="font-bold text-sm text-teal-950 mb-1">Manufacturer Warranty Statement</h4>
                        <p>{{ $product->warranty_info ?? '1-year standard warranty on parts and labour.' }}</p>
                    </div>

                    <h4 class="font-bold text-slate-900">After-Sales Engineering Services</h4>
                    <ul class="list-disc pl-5 space-y-2 text-xs text-slate-600">
                        <li><strong>Annual Maintenance Contracts (AMC):</strong> Optional comprehensive preventive maintenance visits every 6 months.</li>
                        <li><strong>Biomedical Calibration:</strong> Certified calibration with issued audit certificates for clinical accreditation.</li>
                        <li><strong>Original Spare Parts:</strong> Guaranteed access to genuine OEM spare parts and consumables for minimum 7 years.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Related Equipment Showcase -->
        @if($relatedProducts->isNotEmpty())
            <div class="mt-16 space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-teal-600">Complementary Solutions</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Related Medical Equipment</h2>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $rel)
                        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase block mb-1">{{ $rel->brand?->name }}</span>
                                <a href="{{ route('products.show', $rel->slug) }}" class="text-sm font-bold text-slate-900 hover:text-teal-700 transition line-clamp-2">
                                    {{ $rel->name }}
                                </a>
                                <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $rel->short_description }}</p>
                            </div>
                            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-xs font-extrabold text-slate-900">{{ $rel->formatted_price }}</span>
                                <a href="{{ route('products.show', $rel->slug) }}" class="text-xs font-semibold text-teal-600 hover:underline">
                                    Details &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

@endsection

