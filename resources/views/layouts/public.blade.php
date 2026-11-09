<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0f2d47">

    <title>@yield('title', $company['name'] . ' | Medical equipment dealers in Lagos')</title>
    <meta name="description" content="@yield('meta_description', 'Dealers in all types of medical equipment: ultrasound systems, CT scanners, X-ray machines, ventilators, vital sign monitors, dialysis machines, analyzers, MRI and mammography. Based in Lagos, Nigeria.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Serif:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        .nav-link { position: relative; padding: 1rem 0; font-size: 15px; font-weight: 700; color: #1f2430; white-space: nowrap; }
        .nav-link:hover { color: #1b5385; }
        .nav-link.is-active { color: #2166a1; }
        .nav-link.is-active::after, .nav-link:hover::after { content: ""; position: absolute; left: 0; right: 0; bottom: -1px; height: 3px; background: #2166a1; }
    </style>
</head>
@php
    $phoneDigits = $company['phone'] ? preg_replace('/[^+\d]/', '', $company['phone']) : null;
    $navLinks = [
        ['Home', route('home'), request()->routeIs('home')],
        ['Brands', route('brands.index'), request()->routeIs('brands.*')],
        ['Services', route('services.index'), request()->routeIs('services.*')],
        ['About us', route('about'), request()->routeIs('about')],
        ['FAQ', route('faq'), request()->routeIs('faq')],
        ['Contact', route('contact'), request()->routeIs('contact')],
    ];
@endphp
<body class="flex min-h-full flex-col font-sans text-[15px] antialiased selection:bg-brand-600 selection:text-white">

    {{-- Utility strip --}}
    <div class="bg-brand-900 text-sm text-white/75">
        <div class="shell flex min-h-9 items-center justify-between gap-4 py-1">
            <div class="flex items-center gap-5">
                <a href="{{ route('orders.track') }}" class="hover:text-white">Track an order</a>
                <a href="{{ route('faq') }}" class="hover:text-white">Help &amp; FAQ</a>
            </div>
            <div class="flex items-center gap-5">
                @if($company['email'])<a href="mailto:{{ $company['email'] }}" class="hidden hover:text-white md:inline">{{ $company['email'] }}</a>@endif
                @if($company['phone'])<a href="tel:{{ $phoneDigits }}" class="font-semibold text-white hover:text-gold-300">{{ $company['phone'] }}</a>@else<span class="hidden sm:inline">Lagos, Nigeria</span>@endif
                @auth
                    @if(auth()->user()->is_staff)<a href="{{ url('/admin') }}" class="font-semibold text-gold-300">Admin</a>@endif
                @endauth
            </div>
        </div>
    </div>

    <header class="site-header sticky top-0 z-40 border-b border-slate-200 bg-white" x-data="{ open: false, cats: false }" @keydown.escape.window="open = false; cats = false">
        <div class="shell">
            <div class="flex items-center gap-3 py-4 lg:gap-10 lg:py-6">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex min-w-0 shrink-0 items-center gap-2.5" aria-label="{{ $company['name'] }} home">
                    <svg class="h-9 w-9 shrink-0 text-brand-600 sm:h-10 sm:w-10" viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linejoin="round" aria-hidden="true">
                        <path d="M15 4h10v11h11v10H25v11H15V25H4V15h11z"/>
                        <path d="M10 20h5l2.5-5 4 10 2.5-5h6" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    <span class="leading-none">
                        <span class="block font-display text-[19px] font-bold tracking-tight text-ink sm:text-[23px]">MedTech</span>
                        <span class="mt-1 block text-[10px] font-bold tracking-[.12em] text-brand-600 sm:text-xs">DISTRIBUTIONS LTD</span>
                    </span>
                </a>

                {{-- Search (laptop and up) --}}
                <form action="{{ route('products.index') }}" method="GET" class="ml-auto hidden min-w-0 flex-1 lg:flex lg:max-w-xl" role="search">
                    <select name="category" aria-label="Category" class="w-40 shrink-0 rounded-l-sm border border-r-0 border-slate-300 bg-white py-2.5 pl-3 pr-7 text-sm text-slate-700 focus:z-10 focus:border-brand-600 focus:ring-0">
                        <option value="">All categories</option>
                        @foreach($navCategories as $cat)<option value="{{ $cat->slug }}" @selected(request('category') === $cat->slug)>{{ $cat->name }}</option>@endforeach
                    </select>
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Search equipment or model" class="min-w-0 flex-1 border border-slate-300 py-2.5 text-sm focus:z-10 focus:border-brand-600 focus:ring-0">
                    <button type="submit" class="rounded-r-sm bg-brand-600 px-5 text-white hover:bg-brand-800" aria-label="Search">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.3-4.3M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
                    </button>
                </form>

                {{-- Contact block (wide screens) --}}
                <div class="hidden items-center gap-3 xl:flex">
                    @if($company['phone'])
                        <a href="tel:{{ $phoneDigits }}" class="flex items-center gap-2.5 text-xs leading-tight text-slate-500 hover:text-brand-700">
                            <svg class="h-7 w-7 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3l1.5 4.5-2.3 1.2a11 11 0 005.6 5.6l1.2-2.3L19 13v3a2 2 0 01-2 2h-1C9.7 18 3 11.3 3 5z"/></svg>
                            <span><b class="block text-sm font-bold text-ink">{{ $company['phone'] }}</b>Talk to our team</span>
                        </a>
                    @else
                        <a href="{{ route('contact') }}" class="flex items-center gap-2.5 text-xs leading-tight text-slate-500 hover:text-brand-700">
                            <svg class="h-7 w-7 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-6.2 7-11a7 7 0 10-14 0c0 4.8 7 11 7 11zm0-8.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z"/></svg>
                            <span><b class="block text-sm font-bold text-ink">Akowonjo, Lagos</b>Visit our warehouse</span>
                        </a>
                    @endif
                </div>

                {{-- Account, cart, menu --}}
                <div class="ml-auto flex items-center gap-0.5 lg:ml-0">
                    <a href="{{ route('cart.index') }}" class="relative p-2.5 text-slate-800 hover:text-brand-700" aria-label="Cart, {{ $cartCount }} items">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l2.4 11h10.2L20 7H6.2M9 20h.01M17 20h.01"/></svg>
                        @if($cartCount > 0)<span class="absolute right-0.5 top-0.5 grid h-4 min-w-4 place-items-center bg-brand-600 px-1 text-[10px] font-bold leading-none text-white">{{ $cartCount }}</span>@endif
                    </a>

                    @auth
                        <div class="relative" x-data="{ menu: false }" @click.outside="menu = false">
                            <button @click="menu = !menu" class="flex items-center gap-2 px-2 py-2 text-sm font-semibold text-slate-800 hover:text-brand-700" :aria-expanded="menu">
                                <span class="grid h-8 w-8 place-items-center rounded-full bg-brand-600 text-xs font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                <span class="hidden max-w-[110px] truncate md:inline">{{ Auth::user()->name }}</span>
                            </button>
                            <div x-show="menu" x-cloak class="absolute right-0 mt-1 w-56 border border-slate-200 bg-white py-1 text-sm shadow-lg">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 hover:text-brand-700">Dashboard</a>
                                <a href="{{ route('customer.orders.index') }}" class="block px-4 py-2.5 hover:text-brand-700">Orders</a>
                                <a href="{{ route('customer.quotations.index') }}" class="block px-4 py-2.5 hover:text-brand-700">Quotations</a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 hover:text-brand-700">Account settings</a>
                                <form method="POST" action="{{ route('logout') }}" class="mt-1 border-t border-slate-100 pt-1">@csrf<button type="submit" class="w-full px-4 py-2.5 text-left text-rose-700 hover:underline">Log out</button></form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-2.5 py-2 text-sm font-bold text-slate-800 hover:text-brand-700">Log in</a>
                    @endauth

                    <button @click="open = !open" class="p-2.5 text-slate-800 lg:hidden" aria-label="Menu" :aria-expanded="open">
                        <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                        <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
                    </button>
                </div>
            </div>

            {{-- Mobile and tablet search --}}
            <form action="{{ route('products.index') }}" method="GET" class="flex pb-3 lg:hidden" role="search">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Search equipment or model" class="min-w-0 flex-1 border border-slate-300 py-2.5 text-sm focus:border-brand-600 focus:ring-0">
                <button class="bg-brand-600 px-4 text-white" aria-label="Search"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" d="M21 21l-4.3-4.3M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg></button>
            </form>

            {{-- Main navigation (laptop and up) --}}
            <nav class="hidden items-center gap-8 border-t border-slate-100 lg:flex xl:gap-12" aria-label="Main">
                <a href="{{ $navLinks[0][1] }}" class="nav-link {{ $navLinks[0][2] ? 'is-active' : '' }}">Home</a>
                <div class="relative" @mouseenter="cats = true" @mouseleave="cats = false">
                    <a href="{{ route('products.index') }}" class="nav-link inline-flex items-center gap-1 {{ request()->routeIs('products.*') || request()->routeIs('categories.*') ? 'is-active' : '' }}">
                        Equipment
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2.6" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
                    </a>
                    <div x-show="cats" x-cloak class="absolute left-0 top-full z-50 w-72 border border-slate-200 bg-white py-2 shadow-lg">
                        @foreach($navCategories as $cat)
                            <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="flex items-center justify-between px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-700"><span>{{ $cat->name }}</span><span class="text-xs text-slate-400">{{ $cat->products_count }}</span></a>
                        @endforeach
                        <a href="{{ route('categories.index') }}" class="mt-1 block border-t border-slate-100 px-4 pt-2.5 text-sm font-bold text-brand-700 hover:underline">All categories</a>
                    </div>
                </div>
                @foreach(array_slice($navLinks, 1) as [$label, $href, $active])
                    <a href="{{ $href }}" class="nav-link {{ $active ? 'is-active' : '' }}">{{ $label }}</a>
                @endforeach
                <a href="{{ route('quotations.create') }}" class="btn-primary my-2 ml-auto !px-5 !py-2">Request a quote</a>
            </nav>
        </div>

        {{-- Mobile menu --}}
        <div x-show="open" x-cloak class="max-h-[70vh] overflow-y-auto border-t border-slate-200 bg-white lg:hidden">
            <div class="shell py-2 text-[15px] font-semibold text-slate-800">
                <a href="{{ route('home') }}" class="block border-b border-slate-100 py-3">Home</a>
                <p class="pb-1 pt-4 text-xs font-bold tracking-wide text-slate-400">EQUIPMENT</p>
                @foreach($navCategories as $cat)
                    <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="block border-b border-slate-100 py-2.5 pl-3 text-sm font-medium">{{ $cat->name }}</a>
                @endforeach
                <a href="{{ route('categories.index') }}" class="block py-2.5 pl-3 text-sm font-bold text-brand-700">All categories</a>
                <p class="pb-1 pt-4 text-xs font-bold tracking-wide text-slate-400">COMPANY</p>
                @foreach(array_slice($navLinks, 1) as [$label, $href, $active])
                    <a href="{{ $href }}" class="block border-b border-slate-100 py-3 {{ $active ? 'text-brand-700' : '' }}">{{ $label }}</a>
                @endforeach
                <div class="grid gap-2 py-4">
                    <a href="{{ route('quotations.create') }}" class="btn-primary">Request a quote</a>
                    @guest<a href="{{ route('register') }}" class="btn-quiet">Create an account</a>@endguest
                </div>
            </div>
        </div>
    </header>

    {{-- Flash messages --}}
    @if(session('success') || session('error') || session('info') || session('warning'))
        <div class="shell mt-4 space-y-2">
            @if(session('success'))<div role="alert" class="border-l-4 border-emerald-500 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">{{ session('success') }}</div>@endif
            @if(session('error'))<div role="alert" class="border-l-4 border-rose-500 bg-rose-50 px-4 py-3 text-sm text-rose-900">{{ session('error') }}</div>@endif
            @if(session('info'))<div role="alert" class="border-l-4 border-brand-500 bg-white px-4 py-3 text-sm text-brand-900">{{ session('info') }}</div>@endif
            @if(session('warning'))<div role="alert" class="border-l-4 border-amber-500 bg-amber-50 px-4 py-3 text-sm text-amber-900">{{ session('warning') }}</div>@endif
        </div>
    @endif

    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="mt-28 bg-brand-900 text-white/70 sm:mt-40">
        <div class="shell py-16 sm:py-24">
            <div class="grid gap-14 text-sm sm:grid-cols-2 lg:grid-cols-12">
                <div class="sm:col-span-2 lg:col-span-4">
                    <div class="flex items-center gap-2.5">
                        <svg class="h-9 w-9 text-gold-400" viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linejoin="round" aria-hidden="true"><path d="M15 4h10v11h11v10H25v11H15V25H4V15h11z"/><path d="M10 20h5l2.5-5 4 10 2.5-5h6" stroke-width="1.8" stroke-linecap="round"/></svg>
                        <span class="leading-none"><span class="block font-display text-xl font-bold text-white">MedTech</span><span class="mt-1 block text-xs font-bold tracking-[.12em] text-gold-300">DISTRIBUTIONS LTD</span></span>
                    </div>
                    <p class="mt-6 max-w-sm leading-loose text-white/70">{{ $company['name'] }} deals in all types of medical equipment: ultrasound, CT, X-ray, MRI, mammography, ventilators, monitors, dialysis machines and laboratory analyzers.</p>
                </div>

                <div class="lg:col-span-3">
                    <h3 class="mb-6 font-bold text-white">Visit or contact us</h3>
                    <ul class="space-y-4 text-white/70">
                        <li><span class="block text-xs font-bold text-white/50">WAREHOUSE</span>{{ $company['address'] }}</li>
                        @if($company['phone'])<li><a href="tel:{{ $phoneDigits }}" class="hover:text-white">{{ $company['phone'] }}</a></li>@endif
                        @if($company['email'])<li><a href="mailto:{{ $company['email'] }}" class="break-all hover:text-white">{{ $company['email'] }}</a></li>@endif
                        @if($company['hours'])<li>{{ $company['hours'] }}</li>@endif
                    </ul>
                </div>

                <div class="lg:col-span-2">
                    <h3 class="mb-6 font-bold text-white">Equipment</h3>
                    <ul class="space-y-4 text-white/70">
                        @foreach($navCategories->take(6) as $c)<li><a href="{{ route('products.index', ['category' => $c->slug]) }}" class="hover:text-white">{{ $c->name }}</a></li>@endforeach
                        <li><a href="{{ route('categories.index') }}" class="font-bold text-gold-300 hover:underline">All categories</a></li>
                    </ul>
                </div>

                <div class="lg:col-span-3">
                    <h3 class="mb-6 font-bold text-white">Information</h3>
                    <ul class="space-y-4 text-white/70">
                        <li><a href="{{ route('quotations.create') }}" class="hover:text-white">Request a quote</a></li>
                        <li><a href="{{ route('orders.track') }}" class="hover:text-white">Track an order</a></li>
                        <li><a href="{{ route('services.index') }}" class="hover:text-white">Installation and servicing</a></li>
                        <li><a href="{{ route('faq') }}" class="hover:text-white">FAQ</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-white">Terms of supply</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-white">Privacy policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="border-t border-slate-200 text-sm text-slate-500">
            <div class="shell flex flex-col items-center justify-between gap-2 py-6 text-center sm:flex-row sm:text-left">
                <p>&copy; {{ date('Y') }} {{ $company['name'] }}. All rights reserved.</p>
                <p>Payments by card or bank transfer through Paystack and Flutterwave</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
