@extends('layouts.public')

@section('title', 'About MedEquip Pro — Professional Medical Equipment Supplier')
@section('meta_description', 'Learn about MedEquip Pro, our mission to advance healthcare infrastructure across Nigeria and West Africa through genuine clinical equipment and engineering support.')

@section('content')

    <!-- About Header -->
    <div class="bg-gradient-to-br from-slate-900 to-teal-950 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-slate-400 mb-3 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-teal-400 transition">Home</a>
                <span>/</span>
                <span class="text-white font-semibold">About Us</span>
            </nav>
            <div class="max-w-3xl space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-500/10 border border-teal-500/30 text-teal-300 text-xs font-semibold">
                    Medical Equipment &bull; Clinical Technology &bull; Engineering
                </div>
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                    Advancing Clinical Infrastructure with Uncompromising Quality
                </h1>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                    MedEquip Pro is dedicated to equipping healthcare institutions with verified medical systems from the world's most reputable medical OEMs, backed by on-the-ground biomedical technical support.
                </p>
            </div>
        </div>
    </div>

    <!-- Mission & Quality Pillars -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-6 space-y-6">
                <span class="text-xs font-bold uppercase tracking-wider text-teal-600">Our Heritage &amp; Mission</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Connecting Healthcare Providers to World-Class Technology
                </h2>
                <div class="text-xs sm:text-sm text-slate-600 space-y-4 leading-relaxed">
                    <p>
                        {{ $siteSettings['about_text'] ?? 'With years of experience in the medical equipment industry, MedEquip Pro has built a reputation for reliability, quality and excellent customer service. We partner with leading global manufacturers to bring the best medical technology to healthcare facilities.' }}
                    </p>
                    <p>
                        We understand that in an intensive care unit, a paediatric ward, or an emergency theatre, equipment reliability is not merely a technical specification — it is a matter of human life. For this reason, we maintain zero tolerance for substandard devices, counterfeit spare parts, or uncertified installations.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-200">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                        <span class="text-2xl font-black text-slate-900 block">500+</span>
                        <span class="text-xs text-slate-500">Critical Care Units Deployed</span>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                        <span class="text-2xl font-black text-teal-600 block">36</span>
                        <span class="text-xs text-slate-500">States Nationwide Coverage</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: Compliance & Pillars -->
            <div class="lg:col-span-6 space-y-4">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-2">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center font-bold">1</div>
                        <h3 class="font-bold text-slate-900 text-sm">Regulatory Conformity &amp; Authentic Sourcing</h3>
                    </div>
                    <p class="text-xs text-slate-500 pl-13 leading-relaxed">
                        Every single device we supply is traceable to the original manufacturer, carrying legitimate CE, FDA, and local NAFDAC compliance certifications with verifiable batch serials.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-2">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-700 flex items-center justify-center font-bold">2</div>
                        <h3 class="font-bold text-slate-900 text-sm">In-House Biomedical Engineering</h3>
                    </div>
                    <p class="text-xs text-slate-500 pl-13 leading-relaxed">
                        We do not act as mere box shifters. Our engineers conduct pre-delivery electrical safety testing, on-site commissioning, gas supply calibration, and operator handover protocols.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-2">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center font-bold">3</div>
                        <h3 class="font-bold text-slate-900 text-sm">Rapid Sourcing &amp; Tender Execution</h3>
                    </div>
                    <p class="text-xs text-slate-500 pl-13 leading-relaxed">
                        Whether you are outfitting a 100-bed hospital expansion or replacing a single ultrasound probe, our procurement team responds with prompt quotations, transparent shipping schedules, and flexible payment arrangements.
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- Who We Serve -->
    <div class="bg-slate-100 py-16 border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs font-bold uppercase tracking-wider text-teal-600">Client Sectors</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">
                    Who We Partner With
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 text-center space-y-2">
                    <div class="w-12 h-12 rounded-full bg-teal-50 text-teal-700 mx-auto flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h3 class="font-bold text-sm text-slate-900">Teaching &amp; Tertiary Hospitals</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">High-acuity ICU ventilators, multi-parameter monitors, and neonatal incubators.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 text-center space-y-2">
                    <div class="w-12 h-12 rounded-full bg-teal-50 text-teal-700 mx-auto flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 class="font-bold text-sm text-slate-900">Private Specialty Clinics</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Surgery centres, maternity homes, cardiology clinics and day-care surgical units.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 text-center space-y-2">
                    <div class="w-12 h-12 rounded-full bg-teal-50 text-teal-700 mx-auto flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    </div>
                    <h3 class="font-bold text-sm text-slate-900">Diagnostic Laboratories</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Automated biochemistry analysers, haematology counters, centrifuges and microscopes.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 text-center space-y-2">
                    <div class="w-12 h-12 rounded-full bg-teal-50 text-teal-700 mx-auto flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="font-bold text-sm text-slate-900">Emergency &amp; Transport Services</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Military-grade portable transport ventilators, defibrillators, and mobile oxygen.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Reused -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-bold uppercase tracking-wider text-teal-600">Client Endorsements</span>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">What Medical Directors Say</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($testimonials as $t)
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-4">
                    <p class="text-xs text-slate-600 leading-relaxed italic">&ldquo;{{ $t->content }}&rdquo;</p>
                    <div class="pt-4 border-t border-slate-100">
                        <h4 class="font-bold text-xs text-slate-900">{{ $t->name }}</h4>
                        <p class="text-[10px] text-teal-700 font-medium">{{ $t->title }}</p>
                        <p class="text-[10px] text-slate-400">{{ $t->organization }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection

