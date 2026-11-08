@extends('layouts.public')

@section('title', $product->meta_title ?? ($product->name . ' | MedTech Distributions'))
@section('meta_description', $product->meta_description ?? $product->short_description)

@section('content')

    <div class="page-head">
        <div class="shell py-12 sm:py-16">
            <nav class="crumbs flex flex-wrap gap-x-2" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span>/</span>
                <a href="{{ route('products.index') }}">Equipment</a>
                @if($product->category)<span>/</span><a href="{{ route('products.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>@endif
                <span>/</span><span class="text-slate-700">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <div class="shell py-14 sm:py-20" x-data="{ tab: 'specs' }">
        <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">

            {{-- Gallery --}}
            <div class="lg:col-span-5" x-data="{ current: '{{ $product->primary_image_url }}' }">
                <div class="relative flex min-h-[340px] items-center justify-center border border-slate-200 bg-white p-8">
                    <template x-if="current"><img :src="current" alt="{{ $product->name }}" class="max-h-80 max-w-full object-contain"></template>
                    <template x-if="!current"><div><x-equip-art :slug="$product->category?->slug" :name="$product->name" class="max-h-72" /></div></template>
                    @if($product->is_new)<span class="absolute left-0 top-0 bg-brand-600 px-2.5 py-1 text-xs font-semibold text-white">New</span>@endif
                </div>

                @if($product->images->count() > 1)
                    <div class="mt-3 flex gap-2 overflow-x-auto">
                        @foreach($product->images as $image)
                            <button @click="current = '{{ $image->url }}'" class="flex h-16 w-16 shrink-0 items-center justify-center border bg-white p-1.5" :class="current === '{{ $image->url }}' ? 'border-brand-600' : 'border-slate-200 hover:border-slate-400'" aria-label="Show photo {{ $loop->iteration }}">
                                <img src="{{ $image->url }}" alt="" class="max-h-full max-w-full object-contain">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Summary --}}
            <div class="lg:col-span-7">
                <p class="text-sm text-slate-500">
                    @if($product->brand)<a href="{{ route('products.index', ['brand' => $product->brand->slug]) }}" class="font-semibold text-brand-700 hover:underline">{{ $product->brand->name }}</a> &nbsp;|&nbsp; @endif
                    SKU {{ $product->sku }}@if($product->model_number) &nbsp;|&nbsp; Model {{ $product->model_number }}@endif
                </p>
                <h1 class="mt-1 text-2xl font-bold leading-tight text-ink sm:text-[30px]">{{ $product->name }}</h1>

                <div class="mt-5 flex flex-wrap items-baseline gap-x-4 gap-y-1">
                    <span class="font-display text-3xl font-bold text-ink">{{ $product->formatted_price }}</span>
                    @if(!$product->isQuoteOnly() && $product->compare_price && $product->compare_price > $product->price)
                        <s class="text-sm text-slate-400">{{ number_format($product->compare_price, 2) }} {{ config('env.DEFAULT_CURRENCY', 'NGN') }}</s>
                    @endif
                    <span class="text-sm font-semibold {{ $product->isInStock() ? 'text-emerald-700' : 'text-amber-700' }}">
                        {{ $product->isInStock() ? 'In stock, ' . $product->available_stock . ' available' : 'On order, ask us for the lead time' }}
                    </span>
                </div>

                <p class="mt-4 max-w-2xl text-[15px] leading-relaxed text-slate-700">{{ $product->short_description }}</p>

                <div class="mt-6 flex flex-col gap-3 border-y border-slate-200 py-5 sm:flex-row sm:items-center">
                    @if(!$product->isQuoteOnly())
                        <form action="{{ route('cart.add') }}" method="POST" class="flex flex-1 items-center gap-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <label for="quantity" class="sr-only">Quantity</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ max(1, $product->available_stock) }}" class="field !w-20 text-center">
                            <button type="submit" class="btn-primary flex-1 !py-3">Add to cart</button>
                        </form>
                    @endif
                    <a href="{{ route('quotations.create', ['product' => $product->slug]) }}" class="{{ $product->isQuoteOnly() ? 'btn-primary' : 'btn-outline' }} !py-3">Request a quote</a>
                </div>

                <dl class="mt-5 grid gap-x-8 gap-y-3 text-sm sm:grid-cols-2">
                    <div>
                        <dt class="font-bold text-ink">Installation</dt>
                        <dd class="text-slate-600">Our biomedical engineers can install, calibrate and train your staff.</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-ink">Warranty</dt>
                        <dd class="text-slate-600">{{ $product->warranty_info ?? 'Ask us for the manufacturer warranty terms.' }}</dd>
                    </div>
                </dl>

                <p class="mt-5 text-sm text-slate-600">
                    Questions about configuration?
                    <a href="{{ route('contact', ['product_id' => $product->id]) }}" class="font-semibold text-brand-700 hover:underline">Talk to an engineer</a>
                </p>
            </div>
        </div>

        {{-- Details --}}
        <div class="mt-20">
            <div class="flex gap-8 overflow-x-auto border-b border-slate-200" role="tablist">
                @foreach(['specs' => 'Specifications', 'description' => 'Overview', 'features' => 'Features', 'warranty' => 'Warranty and service'] as $key => $label)
                    <button role="tab" @click="tab = '{{ $key }}'" :aria-selected="tab === '{{ $key }}'" class="-mb-px whitespace-nowrap border-b-2 py-3 text-[15px] font-semibold" :class="tab === '{{ $key }}' ? 'border-brand-600 text-brand-700' : 'border-transparent text-slate-500 hover:text-ink'">{{ $label }}</button>
                @endforeach
            </div>

            <div x-show="tab === 'specs'" class="max-w-3xl py-6">
                @forelse($specificationsByGroup as $groupName => $specs)
                    <h3 class="mb-2 mt-6 text-[15px] font-bold text-ink first:mt-0">{{ $groupName }}</h3>
                    <dl class="divide-y divide-slate-200 border-y border-slate-200 text-sm">
                        @foreach($specs as $s)
                            <div class="grid gap-1 py-2.5 sm:grid-cols-3">
                                <dt class="font-semibold text-slate-700">{{ $s->label }}</dt>
                                <dd class="text-slate-600 sm:col-span-2">{{ $s->value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                @empty
                    <p class="text-sm text-slate-600">We haven't published a specification sheet for this item yet. <a href="{{ route('contact', ['product_id' => $product->id]) }}" class="font-semibold text-brand-700 hover:underline">Ask for the manufacturer datasheet.</a></p>
                @endforelse
            </div>

            <div x-show="tab === 'description'" x-cloak class="max-w-3xl whitespace-pre-line py-6 text-[15px] leading-relaxed text-slate-700">{{ $product->description ?? $product->short_description }}</div>

            <div x-show="tab === 'features'" x-cloak class="max-w-3xl py-6">
                @if($product->features)
                    <ul class="space-y-2 text-[15px] text-slate-700">
                        @foreach(explode("\n", $product->features) as $feature)
                            @if(trim($feature))
                                <li class="flex gap-3"><span class="mt-2 h-1.5 w-1.5 shrink-0 bg-brand-600"></span>{{ trim($feature) }}</li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-slate-600">No feature list yet. <a href="{{ route('contact', ['product_id' => $product->id]) }}" class="font-semibold text-brand-700 hover:underline">Ask us</a> and we will send one.</p>
                @endif
            </div>

            <div x-show="tab === 'warranty'" x-cloak class="max-w-3xl py-6 text-[15px] leading-relaxed text-slate-700">
                <p>{{ $product->warranty_info ?? 'Ask us for the manufacturer warranty terms for this item.' }}</p>
                <p class="mt-3">After the sale we can arrange scheduled maintenance, calibration with a certificate for your records, and original spare parts and consumables. <a href="{{ route('services.index') }}" class="font-semibold text-brand-700 hover:underline">See our services</a>.</p>
            </div>
        </div>

        {{-- Related --}}
        @if($relatedProducts->isNotEmpty())
            <div class="mt-28">
                <h2 class="sec-title mb-12">Related equipment</h2>
                <div class="grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-8 md:grid-cols-4">
                    @foreach($relatedProducts as $rel)
                        <div>
                            <a href="{{ route('products.show', $rel->slug) }}" class="tile" aria-label="{{ $rel->name }}">
                                <div class="tile-img">
                                    @if($rel->primary_image_url)<img src="{{ $rel->primary_image_url }}" alt="{{ $rel->name }}" loading="lazy">@else<x-equip-art :slug="$rel->category?->slug" :name="$rel->name" />@endif
                                    <div class="tile-veil"><span>DETAILS</span></div>
                                </div>
                            </a>
                            <div class="pt-2 text-center">
                                <a href="{{ route('products.show', $rel->slug) }}" class="block truncate text-[13px] text-slate-600 hover:text-brand-700">{{ $rel->name }}</a>
                                <p class="text-sm font-bold text-ink">{{ $rel->formatted_price }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

@endsection
