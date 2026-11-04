<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 text-slate-800">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'MedEquip Pro — Professional Medical Equipment Supplier')</title>
    <meta name="description" content="@yield('meta_description', 'Leading medical equipment supplier for hospitals and clinics. ICU ventilators, patient monitors, oxygen concentrators, hospital beds and diagnostic equipment.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="flex min-h-full flex-col font-sans antialiased selection:bg-teal-600 selection:text-white">

    <!-- Top Announcement & Quick Contact Bar -->
    <div class="bg-slate-900 text-xs text-slate-300 border-b border-slate-800 py-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center space-x-4">
                <span class="inline-flex items-center gap-1.5 text-teal-400 font-medium">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Certified Medical Supplier
                </span>
                <span class="hidden sm:inline text-slate-500">|</span>
                <a href="tel:{{ $siteSettings['company_phone'] ?? '+2340000000000' }}" class="hidden sm:inline-flex items-center gap-1 hover:text-white transition">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span>{{ $siteSettings['company_phone'] ?? '+234 000 000 0000' }}</span>
                </a>
                <span class="hidden md:inline text-slate-500">|</span>
                <a href="mailto:{{ $siteSettings['company_email'] ?? 'info@medequippro.com' }}" class="hidden md:inline-flex items-center gap-1 hover:text-white transition">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>{{ $siteSettings['company_email'] ?? 'info@medequippro.com' }}</span>
                </a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('orders.track') }}" class="hover:text-teal-400 transition inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Track Order
                </a>
                <span class="text-slate-500">|</span>
                <a href="{{ route('faq') }}" class="hover:text-white transition">FAQs</a>
                @auth
                    @if(auth()->user()->is_staff)
                        <span class="text-slate-500">|</span>
                        <a href="{{ url('/admin') }}" class="text-amber-400 font-semibold hover:text-amber-300 transition">Admin Panel</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm" x-data="{ mobileMenuOpen: false, categoryDropdown: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-teal-700 via-teal-600 to-cyan-500 flex items-center justify-center text-white shadow-md shadow-teal-500/20 group-hover:scale-105 transition-transform">
                            <!-- Medical Cross with Pulse -->
                            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 10.5h-5.5V5c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v5.5H5c-.83 0-1.5.67-1.5 1.5s.67 1.5 1.5 1.5h5.5V19c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5v-5.5H19c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-2xl font-black tracking-tight text-slate-900 flex items-center">
                                MedEquip<span class="text-teal-600 font-extrabold ml-1">Pro</span>
                            </span>
                            <span class="block text-[10px] tracking-wider font-semibold uppercase text-slate-500 -mt-1">
                                Clinical Systems & Supplies
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Search Bar (Desktop) -->
                <div class="hidden lg:flex flex-1 max-w-md mx-6">
                    <form action="{{ route('products.index') }}" method="GET" class="w-full relative">
                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Search ICU ventilators, monitors, pumps, spares..."
                            class="w-full pl-10 pr-24 py-2 text-sm bg-slate-50 border border-slate-300 rounded-full focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition"
                        />
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <button type="submit" class="absolute right-1 top-1 bottom-1 px-4 text-xs font-semibold text-white bg-teal-600 hover:bg-teal-700 rounded-full transition">
                            Search
                        </button>
                    </form>
                </div>

                <!-- Navigation Links & Actions -->
                <div class="hidden xl:flex items-center space-x-7 text-sm font-medium text-slate-700">
                    <a href="{{ route('home') }}" class="hover:text-teal-600 transition {{ request()->routeIs('home') ? 'text-teal-600 font-semibold' : '' }}">Home</a>
                    
                    <!-- Categories Dropdown -->
                    <div class="relative" @mouseenter="categoryDropdown = true" @mouseleave="categoryDropdown = false">
                        <button class="flex items-center gap-1 hover:text-teal-600 transition py-2 {{ request()->routeIs('products.*') || request()->routeIs('categories.*') ? 'text-teal-600 font-semibold' : '' }}">
                            <span>Equipment Catalog</span>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': categoryDropdown }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        
                        <div
                            x-show="categoryDropdown"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute left-0 mt-0 w-72 bg-white rounded-xl shadow-xl border border-slate-100 py-3 z-50 divide-y divide-slate-100"
                            style="display: none;"
                        >
                            <div class="px-4 py-2">
                                <a href="{{ route('products.index') }}" class="text-xs font-bold text-teal-700 uppercase tracking-wider hover:underline flex items-center justify-between">
                                    <span>Browse All Products</span>
                                    <span>&rarr;</span>
                                </a>
                            </div>
                            <div class="py-1">
                                @forelse($navCategories as $cat)
                                    <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50 hover:text-teal-800 flex items-center justify-between transition">
                                        <span>{{ $cat->name }}</span>
                                        <span class="text-[10px] text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">{{ $cat->products_count }}</span>
                                    </a>
                                @empty
                                    <a href="{{ route('products.index') }}" class="px-4 py-2 text-xs text-slate-500">All Equipment</a>
                                @endforelse
                            </div>
                            <div class="px-4 py-2">
                                <a href="{{ route('categories.index') }}" class="text-xs font-medium text-slate-500 hover:text-teal-600">
                                    View all 10+ categories
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('brands.index') }}" class="hover:text-teal-600 transition {{ request()->routeIs('brands.*') ? 'text-teal-600 font-semibold' : '' }}">Brands</a>
                    <a href="{{ route('services.index') }}" class="hover:text-teal-600 transition {{ request()->routeIs('services.*') ? 'text-teal-600 font-semibold' : '' }}">Services</a>
                    <a href="{{ route('about') }}" class="hover:text-teal-600 transition {{ request()->routeIs('about') ? 'text-teal-600 font-semibold' : '' }}">About</a>
                    <a href="{{ route('contact') }}" class="hover:text-teal-600 transition {{ request()->routeIs('contact') ? 'text-teal-600 font-semibold' : '' }}">Contact</a>
                </div>

                <!-- Right Action Buttons -->
                <div class="flex items-center space-x-3">
                    
                    <!-- Quote Button -->
                    <a href="{{ route('quotations.create') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold rounded-lg bg-teal-50 text-teal-700 border border-teal-200 hover:bg-teal-100 transition shadow-sm">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Request Quote</span>
                    </a>

                    <!-- Shopping Cart -->
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-slate-600 hover:text-teal-600 hover:bg-slate-100 rounded-full transition" title="Shopping Cart">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        @if($cartCount > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-teal-600 rounded-full animate-pulse">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Auth Dropdown / Portal -->
                    @auth
                        <div class="relative" x-data="{ userMenu: false }">
                            <button @click="userMenu = !userMenu" @click.outside="userMenu = false" class="flex items-center gap-2 p-1.5 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                                <div class="w-7 h-7 rounded-full bg-teal-700 text-white flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden md:inline max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div
                                x-show="userMenu"
                                x-transition
                                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50"
                                style="display: none;"
                            >
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="text-xs font-semibold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-teal-50 hover:text-teal-800">Customer Dashboard</a>
                                <a href="{{ route('customer.orders.index') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-teal-50 hover:text-teal-800">My Orders</a>
                                <a href="{{ route('customer.quotations.index') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-teal-50 hover:text-teal-800">My Quotations</a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-teal-50 hover:text-teal-800">Account Settings</a>
                                <div class="border-t border-slate-100 mt-1 pt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-xs text-rose-600 hover:bg-rose-50 font-medium">
                                            Log Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-1 px-3.5 py-2 text-xs font-medium text-slate-700 hover:text-teal-700 transition">
                            Log In
                        </a>
                        <a href="{{ route('register') }}" class="hidden sm:inline-flex items-center gap-1 px-3.5 py-2 text-xs font-semibold text-white bg-slate-900 hover:bg-teal-700 rounded-lg transition shadow-sm">
                            Register
                        </a>
                    @endauth

                    <!-- Mobile Hamburger -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="xl:hidden p-2 text-slate-600 hover:text-slate-900 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Search Bar -->
            <div class="lg:hidden pb-4">
                <form action="{{ route('products.index') }}" method="GET" class="relative">
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Search medical equipment..."
                        class="w-full pl-9 pr-20 py-2 text-xs bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                    />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <button type="submit" class="absolute right-1 top-1 bottom-1 px-3 text-[11px] font-semibold text-white bg-teal-600 rounded-md">
                        Search
                    </button>
                </form>
            </div>
        </div>

        <!-- Mobile Slide-out Menu -->
        <div x-show="mobileMenuOpen" x-transition class="xl:hidden bg-white border-b border-slate-200 px-4 pt-2 pb-6 space-y-2" style="display: none;">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-slate-700 hover:bg-teal-50 hover:text-teal-700">Home</a>
            <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-slate-700 hover:bg-teal-50 hover:text-teal-700">All Equipment</a>
            <a href="{{ route('categories.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-slate-700 hover:bg-teal-50 hover:text-teal-700">Categories</a>
            <a href="{{ route('brands.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-slate-700 hover:bg-teal-50 hover:text-teal-700">Brands</a>
            <a href="{{ route('services.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-slate-700 hover:bg-teal-50 hover:text-teal-700">Services</a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-slate-700 hover:bg-teal-50 hover:text-teal-700">About Us</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-slate-700 hover:bg-teal-50 hover:text-teal-700">Contact Us</a>
            <a href="{{ route('quotations.create') }}" class="block px-3 py-2 rounded-md text-sm font-bold text-teal-700 bg-teal-50">Request a Custom Quotation</a>
            @guest
                <div class="pt-4 border-t border-slate-100 flex gap-2">
                    <a href="{{ route('login') }}" class="flex-1 text-center py-2 text-xs font-semibold border border-slate-300 rounded-lg">Log In</a>
                    <a href="{{ route('register') }}" class="flex-1 text-center py-2 text-xs font-semibold bg-teal-600 text-white rounded-lg">Register</a>
                </div>
            @endguest
        </div>
    </header>

    <!-- Global Toast / Flash Notifications -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-800 flex items-start gap-3 shadow-sm" role="alert">
                <svg class="w-5 h-5 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="text-sm font-medium">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-xl bg-rose-50 border border-rose-200 p-4 text-rose-800 flex items-start gap-3 shadow-sm" role="alert">
                <svg class="w-5 h-5 text-rose-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="text-sm font-medium">{{ session('error') }}</div>
            </div>
        @endif

        @if(session('info'))
            <div class="rounded-xl bg-blue-50 border border-blue-200 p-4 text-blue-800 flex items-start gap-3 shadow-sm" role="alert">
                <svg class="w-5 h-5 text-blue-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="text-sm font-medium">{{ session('info') }}</div>
            </div>
        @endif

        @if(session('warning'))
            <div class="rounded-xl bg-amber-50 border border-amber-200 p-4 text-amber-800 flex items-start gap-3 shadow-sm" role="alert">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <div class="text-sm font-medium">{{ session('warning') }}</div>
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Professional Medical Footer -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-12 mt-20 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
                
                <!-- Col 1 & 2: Brand Info -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-teal-700 to-cyan-500 flex items-center justify-center text-white shadow-md">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 10.5h-5.5V5c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v5.5H5c-.83 0-1.5.67-1.5 1.5s.67 1.5 1.5 1.5h5.5V19c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5v-5.5H19c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5z"/>
                            </svg>
                        </div>
                        <span class="text-2xl font-black tracking-tight text-white">
                            MedEquip<span class="text-teal-400">Pro</span>
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed max-w-sm">
                        {{ $siteSettings['company_description'] ?? 'MedEquip Pro supplies high-precision medical devices, intensive care ventilators, patient monitors, diagnostic equipment and consumables to hospitals and clinics across Nigeria and West Africa.' }}
                    </p>
                    <div class="pt-2 text-xs space-y-1.5 text-slate-400">
                        <p class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-teal-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            <span>{{ $siteSettings['company_address'] ?? 'Victoria Island, Lagos, Nigeria' }}</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-teal-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>{{ $siteSettings['company_phone'] ?? '+234 000 000 0000' }}</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-teal-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $siteSettings['business_hours'] ?? 'Mon–Fri 8:00 AM – 6:00 PM' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Col 3: Popular Categories -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-white mb-4">Equipment Categories</h3>
                    <ul class="space-y-2 text-xs text-slate-400">
                        @foreach($navCategories->take(6) as $c)
                            <li>
                                <a href="{{ route('products.index', ['category' => $c->slug]) }}" class="hover:text-teal-400 transition">
                                    {{ $c->name }}
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a href="{{ route('categories.index') }}" class="text-teal-400 hover:underline">
                                Browse All Categories &rarr;
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Services & Solutions -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-white mb-4">Services & Solutions</h3>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="{{ route('services.index') }}" class="hover:text-teal-400 transition">Equipment Sales & Supply</a></li>
                        <li><a href="{{ route('services.index') }}" class="hover:text-teal-400 transition">Installation & Commissioning</a></li>
                        <li><a href="{{ route('services.index') }}" class="hover:text-teal-400 transition">Preventive Maintenance Contracts</a></li>
                        <li><a href="{{ route('services.index') }}" class="hover:text-teal-400 transition">Biomedical Engineer Training</a></li>
                        <li><a href="{{ route('services.index') }}" class="hover:text-teal-400 transition">Genuine Spare Parts Supply</a></li>
                        <li><a href="{{ route('quotations.create') }}" class="text-teal-400 hover:underline font-semibold">Institutional RFQ & Quotes &rarr;</a></li>
                    </ul>
                </div>

                <!-- Col 5: Help & Account -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-white mb-4">Help & Portal</h3>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="{{ route('orders.track') }}" class="hover:text-teal-400 transition">Track Your Order</a></li>
                        <li><a href="{{ route('faq') }}" class="hover:text-teal-400 transition">Frequently Asked Questions</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-teal-400 transition">Contact Medical Support</a></li>
                        <li><a href="{{ route('dashboard') }}" class="hover:text-teal-400 transition">Customer Portal</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-teal-400 transition">Terms of Supply & Warranty</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-teal-400 transition">Privacy Policy</a></li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Note & Disclaimer -->
            <div class="mt-12 pt-8 border-t border-slate-800 text-[11px] text-slate-500 flex flex-col md:flex-row items-center justify-between gap-4">
                <p>&copy; {{ date('Y') }} MedEquip Pro. All rights reserved. Registered medical device distributor.</p>
                <div class="flex items-center gap-4 text-slate-400">
                    <span class="inline-flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-teal-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        NAFDAC / ISO Compliant Sourcing
                    </span>
                    <span>&bull;</span>
                    <span>Paystack &amp; Flutterwave Secured</span>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>

