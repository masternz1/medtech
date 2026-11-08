@extends('layouts.public')

@section('title', 'Brands we supply | MedTech Distributions')
@section('meta_description', 'The manufacturers whose ventilators, sensors and spare parts we supply and service.')

@section('content')

    <div class="page-head">
        <div class="shell py-12 sm:py-16">
            <nav class="crumbs flex gap-x-2" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><span class="text-slate-700">Brands</span></nav>
            <h1 class="mt-5">Brands we supply</h1>
            <p class="mt-4 max-w-2xl text-sm text-slate-600">Equipment and parts come from the manufacturer or its authorised channel, with the manufacturer's warranty.</p>
        </div>
    </div>

    <div class="shell py-14 sm:py-20">
        <ul class="grid gap-x-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($brands as $brand)
                <li class="flex items-baseline justify-between gap-4 border-b border-slate-200 py-4">
                    <div class="min-w-0">
                        <a href="{{ route('products.index', ['brand' => $brand->slug]) }}" class="font-display text-lg font-bold text-brand-700 hover:underline">{{ $brand->name }}</a>
                        @if($brand->website)
                            <a href="{{ $brand->website }}" target="_blank" rel="noopener noreferrer" class="mt-0.5 block truncate text-[13px] text-slate-500 hover:text-brand-700">Manufacturer website</a>
                        @endif
                    </div>
                    <span class="shrink-0 text-sm text-slate-500">{{ $brand->products_count }} {{ \Illuminate\Support\Str::plural('item', $brand->products_count) }}</span>
                </li>
            @endforeach
        </ul>
    </div>

@endsection
