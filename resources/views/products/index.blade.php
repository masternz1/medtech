@extends('layouts.public')

@section('title', 'Equipment catalogue | MedTech Distributions')
@section('meta_description', 'Browse ICU ventilators, portable ventilators, BiPAPs, oxygen blenders, sensors and spare parts. Order online or request a quote.')

@section('content')

    <div class="page-head">
        <div class="shell py-12 sm:py-16">
            <nav class="crumbs flex flex-wrap gap-x-2" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span>/</span>
                <span class="text-slate-700">Equipment</span>
                @if($currentCategory)<span>/</span><span class="text-slate-700">{{ $currentCategory->name }}</span>@endif
                @if($currentBrand)<span>/</span><span class="text-slate-700">{{ $currentBrand->name }}</span>@endif
            </nav>
            <div class="mt-2 flex flex-col justify-between gap-3 md:flex-row md:items-end">
                <div>
                    <h1>
                        @if($currentCategory){{ $currentCategory->name }}
                        @elseif($currentBrand){{ $currentBrand->name }} equipment
                        @else Equipment catalogue
                        @endif
                    </h1>
                    @if($currentCategory && $currentCategory->description)
                        <p class="mt-1 max-w-2xl text-sm text-slate-600">{{ $currentCategory->description }}</p>
                    @endif
                </div>
                <a href="{{ route('quotations.create') }}" class="btn-outline self-start md:self-auto">Can't find it? Request a quote</a>
            </div>
        </div>
    </div>

    <div class="shell py-14 sm:py-20">
        <div class="grid gap-12 lg:grid-cols-[250px_minmax(0,1fr)] lg:gap-16">

            {{-- Filters --}}
            <aside x-data="{ f: false }">
                <button type="button" @click="f = !f" :aria-expanded="f" class="btn-quiet w-full lg:hidden">
                    <span x-text="f ? 'Hide filters' : 'Search and filter'"></span>
                </button>
                <form action="{{ route('products.index') }}" method="GET" id="filter-form" :class="f ? '!block mt-3' : ''" class="hidden divide-y divide-slate-200 border-y border-slate-200 text-sm lg:block">
                    <div class="py-6">
                        <label for="f-q" class="mb-1.5 block font-bold text-ink">Search</label>
                        <input id="f-q" type="search" name="q" value="{{ request('q') }}" placeholder="Model or part number" class="field">
                    </div>

                    <div class="py-6">
                        <div class="mb-3 flex items-center justify-between">
                            <span class="font-bold text-ink">Category</span>
                            @if(request('category'))<a href="{{ request()->fullUrlWithQuery(['category' => null, 'page' => 1]) }}" class="text-[13px] text-brand-700 hover:underline">Clear</a>@endif
                        </div>
                        <ul class="max-h-60 space-y-0.5 overflow-y-auto">
                            <li><a href="{{ request()->fullUrlWithQuery(['category' => null, 'page' => 1]) }}" class="block py-1 {{ !request('category') ? 'font-bold text-brand-700' : 'text-slate-600 hover:text-brand-700' }}">All categories</a></li>
                            @foreach($categories as $cat)
                                <li>
                                    <a href="{{ request()->fullUrlWithQuery(['category' => $cat->slug, 'page' => 1]) }}" class="flex justify-between gap-2 py-1 {{ request('category') === $cat->slug ? 'font-bold text-brand-700' : 'text-slate-600 hover:text-brand-700' }}">
                                        <span class="truncate">{{ $cat->name }}</span><span class="text-slate-400">{{ $cat->products_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="py-6">
                        <div class="mb-3 flex items-center justify-between">
                            <span class="font-bold text-ink">Brand</span>
                            @if(request('brand'))<a href="{{ request()->fullUrlWithQuery(['brand' => null, 'page' => 1]) }}" class="text-[13px] text-brand-700 hover:underline">Clear</a>@endif
                        </div>
                        <ul class="max-h-52 space-y-0.5 overflow-y-auto">
                            <li><a href="{{ request()->fullUrlWithQuery(['brand' => null, 'page' => 1]) }}" class="block py-1 {{ !request('brand') ? 'font-bold text-brand-700' : 'text-slate-600 hover:text-brand-700' }}">All brands</a></li>
                            @foreach($brands as $brand)
                                <li>
                                    <a href="{{ request()->fullUrlWithQuery(['brand' => $brand->slug, 'page' => 1]) }}" class="flex justify-between gap-2 py-1 {{ request('brand') === $brand->slug ? 'font-bold text-brand-700' : 'text-slate-600 hover:text-brand-700' }}">
                                        <span class="truncate">{{ $brand->name }}</span><span class="text-slate-400">{{ $brand->products_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div role="group" aria-labelledby="avail-label" class="space-y-3 py-6">
                        <span id="avail-label" class="mb-1.5 block font-bold text-ink">Availability</span>
                        <label class="flex cursor-pointer items-center gap-2">
                            <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }} onchange="document.getElementById('filter-form').submit()" class="rounded-sm text-brand-600 focus:ring-brand-600">
                            In stock only
                        </label>
                        @foreach(['' => 'Buy online or quote', 'fixed' => 'Buy online', 'quote_preferred' => 'Quote only'] as $val => $label)
                            <label class="flex cursor-pointer items-center gap-2">
                                <input type="radio" name="pricing_type" value="{{ $val }}" {{ (string) request('pricing_type') === (string) $val ? 'checked' : '' }} onchange="document.getElementById('filter-form').submit()" class="text-brand-600 focus:ring-brand-600">
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>

                    <div class="space-y-3 py-6">
                        <button type="submit" class="btn-primary w-full">Apply filters</button>
                        @if(request()->anyFilled(['q', 'category', 'brand', 'in_stock', 'pricing_type', 'min_price', 'max_price']))
                            <a href="{{ route('products.index') }}" class="block text-center text-[13px] text-slate-500 hover:text-brand-700 hover:underline">Reset all filters</a>
                        @endif
                    </div>
                </form>
            </aside>

            {{-- Results --}}
            <div>
                <div class="mb-5 flex flex-col justify-between gap-3 border-b border-slate-200 pb-3 text-sm text-slate-600 sm:flex-row sm:items-center">
                    <p>
                        @if($products->total())
                            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} items
                        @else
                            No items found
                        @endif
                    </p>
                    <div class="flex items-center gap-2">
                        <label for="sort-select">Sort by</label>
                        <select id="sort-select" onchange="location = this.value" class="field !w-auto !py-1.5 pr-8">
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'featured']) }}" {{ $sort === 'featured' ? 'selected' : '' }}>Featured first</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ $sort === 'price_asc' ? 'selected' : '' }}>Price, low to high</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price, high to low</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}" {{ $sort === 'name_asc' ? 'selected' : '' }}>Name, A to Z</option>
                        </select>
                    </div>
                </div>

                @if($products->isEmpty())
                    <div class="bg-white px-6 py-12 text-center">
                        <h2 class="text-base font-bold text-ink">Nothing matches those filters</h2>
                        <p class="mx-auto mt-2 max-w-md text-sm text-slate-600">Try removing a filter or searching by part number. If you need something we don't list, tell us and we will source it.</p>
                        <div class="mt-5 flex justify-center gap-3">
                            <a href="{{ route('products.index') }}" class="btn-quiet">Clear filters</a>
                            <a href="{{ route('quotations.create') }}" class="btn-primary">Ask us to source it</a>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-2 gap-x-4 gap-y-12 sm:gap-x-8 sm:gap-y-16 md:grid-cols-3 xl:grid-cols-4">
                        @foreach($products as $product)
                            <div class="flex flex-col">
                                <a href="{{ route('products.show', $product->slug) }}" class="tile" aria-label="{{ $product->name }}">
                                    <div class="tile-img">
                                        @if($product->primary_image_url)
                                            <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" loading="lazy">
                                        @else
                                            <x-equip-art :slug="$product->category?->slug" :name="$product->name" />
                                        @endif
                                        @if($product->is_new)<span class="absolute left-0 top-0 bg-brand-600 px-2 py-0.5 text-xs font-semibold text-white">New</span>@endif
                                        <div class="tile-veil"><span>DETAILS</span></div>
                                    </div>
                                </a>
                                <div class="flex flex-1 flex-col pt-5 text-center">
                                    <a href="{{ route('products.show', $product->slug) }}" class="line-clamp-2 text-[15px] leading-snug text-ink hover:text-brand-700">{{ $product->name }}</a>
                                    <p class="mt-2 text-[15px] font-semibold text-brand-700">
                                        {{ $product->formatted_price }}
                                        @if(!$product->isQuoteOnly() && $product->compare_price > $product->price)<s class="ml-1 text-xs font-normal text-slate-400">{{ number_format($product->compare_price, 2) }}</s>@endif
                                    </p>

                                    <div class="mt-auto pt-5">
                                        @if($product->isQuoteOnly())
                                            <a href="{{ route('quotations.create', ['product' => $product->slug]) }}" class="btn-outline w-full !py-1.5">Request quote</a>
                                        @else
                                            <form action="{{ route('cart.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button type="submit" class="btn-primary w-full !py-1.5">Add to cart</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-10">{{ $products->links() }}</div>
                @endif
            </div>
        </div>
    </div>

@endsection
