@extends('layouts.public')

@section('title', 'Equipment categories | MedTech Distributions')
@section('meta_description', 'Browse ultrasound systems, CT scanners, X-ray machines, ventilators, vital sign monitors, dialysis machines, analyzers, MRI and mammography.')

@section('content')

    <div class="page-head">
        <div class="shell py-12 sm:py-16">
            <nav class="crumbs flex gap-x-2" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><span class="text-slate-700">Categories</span></nav>
            <h1 class="mt-5">Equipment categories</h1>
        </div>
    </div>

    <div class="shell py-14 sm:py-20">
        <div class="grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-3">
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="group flex flex-col border border-slate-200 transition hover:border-brand-600">
                    <div class="flex aspect-[4/3] items-center justify-center p-6">
                        <x-equip-art :slug="$category->slug" :name="$category->name" class="max-h-full transition group-hover:scale-105" />
                    </div>
                    <div class="border-t border-slate-200 p-3 sm:p-5">
                        <h2 class="font-display text-[15px] font-bold text-brand-700 group-hover:underline sm:text-lg">{{ $category->name }}</h2>
                        @if($category->description)<p class="mt-1 hidden line-clamp-2 text-sm leading-relaxed text-slate-600 sm:block">{{ $category->description }}</p>@endif
                        <p class="mt-3 text-sm font-bold text-ink">{{ $category->products_count ? $category->products_count . ' ' . \Illuminate\Support\Str::plural('item', $category->products_count) : 'Ask for a quote' }} &rarr;</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

@endsection
