@extends('layouts.public')

@section('title', $service->title . ' — MedEquip Pro Services')

@section('content')

    <div class="bg-white border-b border-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-slate-500 mb-2 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Home</a>
                <span>/</span>
                <a href="{{ route('services.index') }}" class="hover:text-teal-600 transition">Services</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold">{{ $service->title }}</span>
            </nav>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $service->title }}</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <div class="lg:col-span-8 bg-white p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>

                <div class="text-sm text-slate-700 leading-relaxed space-y-4">
                    <p class="text-base font-medium text-slate-800">{{ $service->description }}</p>
                    <p>
                        Healthcare facilities require dependable medical systems that function flawlessly 24 hours a day. Our dedicated engineering department ensures your investments remain compliant with OEM guidelines, regulatory protocols, and patient safety requirements.
                    </p>
                    <h3 class="text-base font-bold text-slate-900 pt-2">Service Deliverables</h3>
                    <ul class="list-disc pl-5 space-y-2 text-xs text-slate-600">
                        <li>Standard Operating Procedure (SOP) documentation and calibration logs.</li>
                        <li>Certified test equipment and electrical safety leakage testing.</li>
                        <li>Detailed diagnostic reports with recommendations for preventative actions.</li>
                        <li>Priority access to genuine OEM spare parts and replacement modules.</li>
                    </ul>
                </div>

                <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('contact', ['subject' => 'Service Booking: ' . $service->title]) }}" class="px-6 py-3 rounded-xl font-bold text-xs text-white bg-teal-600 hover:bg-teal-700 transition shadow-sm">
                        Schedule an Engineering Visit
                    </a>
                </div>
            </div>

            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h3 class="font-bold text-sm text-slate-900">Other Clinical Services</h3>
                    <div class="space-y-2">
                        @foreach($otherServices as $other)
                            <a href="{{ route('services.show', $other->slug) }}" class="block p-3 rounded-xl bg-slate-50 hover:bg-teal-50 text-xs font-medium text-slate-700 hover:text-teal-700 transition">
                                {{ $other->title }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="bg-teal-900 text-white p-6 rounded-2xl space-y-3">
                    <h4 class="font-bold text-sm">Need Rapid Assistance?</h4>
                    <p class="text-xs text-teal-200">Call our direct engineering support desk for emergency maintenance or calibration bookings.</p>
                    <a href="tel:{{ $siteSettings['company_phone'] ?? '+2340000000000' }}" class="block text-center py-2 px-4 rounded-lg bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold text-xs transition">
                        Call Support Hotline
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection

