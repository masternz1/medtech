@extends('layouts.public')

@section('title', 'MedTech Distributions | Medical equipment dealers in Lagos')

@section('content')
@php
    // Banner, category and brand images are stored as relative paths; product paths are used as-is.
    $img = fn ($p) => $p ? (\Illuminate\Support\Str::startsWith($p, ['http', '/']) ? $p : asset('storage/' . $p)) : null;
    $tints = ['', '', '', ''];
@endphp

{{-- Hero --}}
@if($heroBanners->isNotEmpty())
<section class="relative" x-data="{ i: 0, n: {{ $heroBanners->count() }} }" aria-roledescription="carousel" aria-label="Featured">
    <div class="relative h-[340px] overflow-hidden sm:h-[440px] lg:h-[520px]">
        @foreach($heroBanners as $k => $b)
            <div x-show="i === {{ $k }}" @if($k) x-cloak @endif class="absolute inset-0">
                <img src="{{ $img($b->image) }}" alt="" class="absolute inset-0 h-full w-full object-cover" @if($k) loading="lazy" @endif>
                <div class="absolute inset-0 bg-gradient-to-r from-brand-900/70 via-brand-900/20 to-transparent"></div>
                <div class="shell relative flex h-full items-center">
                    <div class="max-w-lg text-white">
                        <h1 class="font-display text-4xl font-bold leading-[1.05] sm:text-5xl">{{ $b->title }}</h1>
                        @if($b->subtitle)<p class="mt-4 text-base leading-relaxed text-white/90">{{ $b->subtitle }}</p>@endif
                        @if($b->link_url)<a href="{{ $b->link_url }}" class="btn mt-7 bg-white !px-7 !py-3.5 text-brand-800 hover:bg-brand-50">{{ $b->link_text ?: 'See more' }}</a>@endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if($heroBanners->count() > 1)
        <button @click="i = (i - 1 + n) % n" class="absolute left-4 top-1/2 grid h-10 w-10 -translate-y-1/2 place-items-center bg-white text-brand-700 hover:bg-brand-600 hover:text-white" aria-label="Previous slide"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.6" viewBox="0 0 24 24"><path d="M15 6l-6 6 6 6"/></svg></button>
        <button @click="i = (i + 1) % n" class="absolute right-4 top-1/2 grid h-10 w-10 -translate-y-1/2 place-items-center bg-white text-brand-700 hover:bg-brand-600 hover:text-white" aria-label="Next slide"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.6" viewBox="0 0 24 24"><path d="M9 6l6 6-6 6"/></svg></button>
    @endif
</section>
@else
<section class="shell grid items-center gap-16 py-16 sm:py-24 lg:grid-cols-12 lg:gap-20 lg:py-32">
    <div class="lg:col-span-7">
        <p class="eyebrow">Medical equipment dealers, Lagos</p>
        <h1 class="mt-8 font-display text-[34px] font-bold leading-[1.15] tracking-tight text-ink sm:text-5xl lg:text-[56px]">Imaging and critical care equipment, <span class="text-brand-600">supplied with care.</span></h1>
        <p class="mt-8 max-w-md text-base leading-[1.9] text-slate-600">Ultrasound, CT, X-ray, MRI, mammography, ventilators, monitors, dialysis machines and analyzers.</p>
        <div class="mt-12 flex flex-col gap-4 sm:flex-row">
            <a href="{{ route('products.index') }}" class="btn-primary btn-lg">Browse equipment</a>
            <a href="{{ route('quotations.create') }}" class="btn-outline btn-lg">Request a quote</a>
        </div>
    </div>
    <div class="lg:col-span-5">
        <a href="{{ route('products.index', ['category' => 'ct-scanners']) }}" class="group relative block border border-slate-200 transition hover:border-brand-600">
            <div class="flex aspect-square items-center justify-center p-12 sm:p-16"><img src="{{ asset('images/equipment/ct-scanners.svg') }}" alt="CT scanner" class="max-h-full max-w-full transition duration-500 group-hover:scale-105"></div>
        </a>
    </div>
</section>
@endif

{{-- Categories --}}
@if($featuredCategories->isNotEmpty())
<section class="shell mt-24 sm:mt-36">
    <div class="mb-12 flex items-end justify-between gap-6">
        <h2 class="sec-title flex-1">Shop by category</h2>
        <a href="{{ route('categories.index') }}" class="shrink-0 text-sm font-bold text-brand-700 hover:underline">All categories</a>
    </div>
    <div class="grid grid-cols-2 gap-4 sm:gap-8 md:grid-cols-3">
        @foreach($featuredCategories as $c)
            <a href="{{ route('products.index', ['category' => $c->slug]) }}" class="group flex flex-col border border-slate-200 transition hover:border-brand-600 max-md:[&:last-child:nth-child(odd)]:col-span-2">
                <div class="flex aspect-[4/3] items-center justify-center p-6 sm:p-10">
                    @if($c->image)<img src="{{ $img($c->image) }}" alt="" loading="lazy" class="max-h-full max-w-full object-contain transition duration-500 group-hover:scale-105">@else<x-equip-art :slug="$c->slug" :name="$c->name" class="max-h-full transition duration-500 group-hover:scale-105" />@endif
                </div>
                <div class="border-t border-slate-200 px-4 py-4 sm:px-7 sm:py-6">
                    <h3 class="font-display text-[15px] font-semibold leading-snug text-ink group-hover:text-brand-700 sm:text-lg">{{ $c->name }}</h3>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif

{{-- Featured products --}}
@if($featuredProducts->isNotEmpty())
<section class="shell mt-24 sm:mt-36">
    <div class="mb-12 flex items-end justify-between gap-6">
        <h2 class="sec-title flex-1">Featured equipment</h2>
        <a href="{{ route('products.index') }}" class="shrink-0 text-sm font-bold text-brand-700 hover:underline">View all</a>
    </div>

    <div class="grid grid-cols-2 gap-x-4 gap-y-12 sm:gap-x-8 sm:gap-y-16 lg:grid-cols-4">
        @foreach($featuredProducts->take(8) as $p)
            <div>
                <a href="{{ route('products.show', $p->slug) }}" class="tile" aria-label="{{ $p->name }}">
                    <div class="tile-img !p-8">
                        @if($p->primary_image_url)<img src="{{ $p->primary_image_url }}" alt="{{ $p->name }}" loading="lazy">@else<x-equip-art :slug="$p->category?->slug" :name="$p->name" />@endif
                        <div class="tile-veil"><span>DETAILS</span></div>
                    </div>
                </a>
                <div class="pt-5 text-center">
                    <a href="{{ route('products.show', $p->slug) }}" class="block truncate text-[15px] text-ink hover:text-brand-700">{{ $p->name }}</a>
                    <p class="mt-2 text-[15px] font-semibold text-brand-700">{{ $p->formatted_price }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

{{-- How ordering works --}}
<section class="shell mt-24 sm:mt-36">
    <h2 class="sec-title mb-14">How ordering works</h2>
    <ol class="grid gap-14 md:grid-cols-3 md:gap-16">
        @foreach([
            ['Choose', 'Browse the catalogue or send us a list of what you need.'],
            ['Pay or request a quote', 'Pay online, or ask for an itemised quotation.'],
            ['We deliver', 'We arrange delivery to your facility.'],
        ] as $n => [$t, $d])
            <li>
                <span class="font-display text-6xl font-light leading-none text-brand-200">{{ $n + 1 }}</span>
                <h3 class="mt-6 font-display text-xl font-semibold text-ink">{{ $t }}</h3>
                <p class="mt-3 text-[15px] leading-[1.9] text-slate-600">{{ $d }}</p>
            </li>
        @endforeach
    </ol>
</section>

{{-- Closing call to action --}}
<section class="shell mt-24 sm:mt-36">
    <div class="border border-slate-200 px-6 py-16 text-center sm:py-24">
        <h2 class="mx-auto max-w-xl font-display text-2xl font-bold leading-snug text-ink sm:text-4xl">Equipping a hospital, clinic or imaging centre?</h2>
        <p class="mx-auto mt-6 max-w-md text-base leading-[1.9] text-slate-600">Send us your list and we will reply with a priced quotation.</p>
        <div class="mt-10 flex flex-col justify-center gap-4 sm:flex-row">
            <a href="{{ route('quotations.create') }}" class="btn-primary btn-lg">Request a quote</a>
            <a href="{{ route('contact') }}" class="btn-quiet btn-lg">Contact us</a>
        </div>
    </div>
</section>

@endsection
