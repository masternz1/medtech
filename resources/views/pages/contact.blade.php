@extends('layouts.public')

@section('title', 'Contact Medical Team — MedEquip Pro')
@section('meta_description', 'Contact our medical equipment procurement and biomedical engineering department for quotations, consultations, or technical service.')

@section('content')

    <div class="bg-white border-b border-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-slate-500 mb-2 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Home</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold">Contact</span>
            </nav>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Contact Our Medical Equipment Specialists</h1>
            <p class="text-sm text-slate-500 mt-1 max-w-2xl">
                Whether you need technical datasheets, institutional pricing, or emergency equipment maintenance, our team of clinical specialists and biomedical engineers is ready to help.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- Left Info Panel (Col 5) -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-slate-900 text-white rounded-2xl p-8 space-y-6">
                    <h2 class="text-xl font-bold tracking-tight">Direct Medical Desk</h2>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Reach out directly to our clinical sales coordinators or biomedical technical support desk.
                    </p>

                    <div class="space-y-4 text-xs text-slate-300">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-teal-400 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            </div>
                            <div>
                                <span class="text-slate-400 block font-medium">Head Office &amp; Warehouse</span>
                                <span class="font-semibold text-white">{{ $siteSettings['company_address'] ?? 'Victoria Island, Lagos, Nigeria' }}</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-teal-400 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <span class="text-slate-400 block font-medium">Phone Enquiries</span>
                                <a href="tel:{{ $siteSettings['company_phone'] ?? '+2340000000000' }}" class="font-semibold text-white hover:text-teal-400 transition">{{ $siteSettings['company_phone'] ?? '+234 000 000 0000' }}</a>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-teal-400 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <span class="text-slate-400 block font-medium">Official Email</span>
                                <a href="mailto:{{ $siteSettings['company_email'] ?? 'info@medequippro.com' }}" class="font-semibold text-white hover:text-teal-400 transition">{{ $siteSettings['company_email'] ?? 'info@medequippro.com' }}</a>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-teal-400 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <span class="text-slate-400 block font-medium">Working Hours</span>
                                <span class="font-semibold text-white">{{ $siteSettings['business_hours'] ?? 'Monday – Friday: 8:00 AM – 6:00 PM' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Emergency Contact Card -->
                <div class="bg-teal-50 border border-teal-200 rounded-2xl p-6 text-xs text-teal-900 space-y-2">
                    <h3 class="font-bold text-sm text-teal-950 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Urgent ICU Equipment Needs?
                    </h3>
                    <p class="text-teal-800 leading-relaxed">
                        For critical intensive care units requiring emergency replacement ventilators or high-flow oxygen equipment, call our 24/7 emergency dispatch coordinator.
                    </p>
                </div>
            </div>

            <!-- Right Form (Col 7) -->
            <div class="lg:col-span-7 bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
                <h2 class="text-xl font-bold text-slate-900 mb-1">Send a Message or Technical Enquiry</h2>
                <p class="text-xs text-slate-500 mb-6">Complete this form and our medical sales engineer will reply within 24 hours.</p>

                @if($selectedProduct)
                    <div class="mb-6 p-3 bg-teal-50 border border-teal-200 rounded-xl flex items-center justify-between text-xs">
                        <span class="text-teal-900 font-medium">Enquiring about: <strong>{{ $selectedProduct->name }}</strong> ({{ $selectedProduct->sku }})</span>
                        <a href="{{ route('contact') }}" class="text-[11px] text-teal-700 hover:underline">Remove</a>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                    @csrf
                    @if($selectedProduct)
                        <input type="hidden" name="product_id" value="{{ $selectedProduct->id }}">
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">Full Name *</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', auth()->user()?->name) }}"
                                required
                                class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                                placeholder="Dr. / Engr. Full Name"
                            />
                            @error('name') <span class="text-[11px] text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">Email Address *</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', auth()->user()?->email) }}"
                                required
                                class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                                placeholder="name@hospital.com"
                            />
                            @error('email') <span class="text-[11px] text-rose-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="block text-xs font-semibold text-slate-700 mb-1">Telephone / WhatsApp</label>
                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                                placeholder="+234 ..."
                            />
                            @error('phone') <span class="text-[11px] text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="organization" class="block text-xs font-semibold text-slate-700 mb-1">Healthcare Facility / Organization</label>
                            <input
                                type="text"
                                id="organization"
                                name="organization"
                                value="{{ old('organization') }}"
                                class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                                placeholder="Hospital, Clinic or Diagnostic Centre"
                            />
                            @error('organization') <span class="text-[11px] text-rose-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="block text-xs font-semibold text-slate-700 mb-1">Subject *</label>
                        <input
                            type="text"
                            id="subject"
                            name="subject"
                            value="{{ old('subject', request('subject', ($selectedProduct ? 'Enquiry regarding ' . $selectedProduct->name : 'Equipment Pricing Enquiry'))) }}"
                            required
                            class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                        />
                        @error('subject') <span class="text-[11px] text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-xs font-semibold text-slate-700 mb-1">Message &amp; Clinical Requirements *</label>
                        <textarea
                            id="message"
                            name="message"
                            rows="5"
                            required
                            class="w-full text-xs p-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                            placeholder="Please provide details about your facility requirements, required quantities, intended clinical application, or technical specifications..."
                        >{{ old('message') }}</textarea>
                        @error('message') <span class="text-[11px] text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full py-3 px-6 rounded-xl font-bold text-xs text-white bg-slate-900 hover:bg-teal-700 transition shadow-md">
                        Submit Medical Enquiry
                    </button>
                </form>
            </div>

        </div>
    </div>

@endsection

