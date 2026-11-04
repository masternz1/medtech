@extends('layouts.public')

@section('title', 'Clinical Biomedical Services — MedEquip Pro')
@section('meta_description', 'Full lifecycle medical equipment services: Installation, Commissioning, Biomedical Engineering Maintenance, and Clinical Staff Training.')

@section('content')

    <div class="bg-white border-b border-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-slate-500 mb-2 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Home</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold">Services</span>
            </nav>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Clinical &amp; Biomedical Engineering Services</h1>
            <p class="text-sm text-slate-500 mt-1 max-w-2xl">
                Beyond equipment supply, our certified biomedical engineers provide full lifecycle support to ensure continuous clinical uptime and compliance with international healthcare standards.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
                <div class="bg-white rounded-2xl border border-slate-200/90 p-7 shadow-sm hover:shadow-md hover:border-teal-300 transition duration-200 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <h2 class="text-lg font-bold text-slate-900">{{ $service->title }}</h2>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            {{ $service->description }}
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('contact', ['subject' => 'Service Enquiry: ' . $service->title]) }}" class="text-xs font-semibold text-teal-700 hover:text-teal-800 inline-flex items-center gap-1">
                            <span>Request This Service</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Consultation Banner -->
        <div class="mt-16 bg-slate-900 rounded-3xl p-8 sm:p-12 text-white flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-xl space-y-2">
                <span class="text-xs uppercase font-bold text-teal-400">Preventive Maintenance Contracts</span>
                <h3 class="text-2xl font-black">Keep Your Critical Care Systems at 99.9% Uptime</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    We offer tailored Service Level Agreements (SLAs) including 6-monthly sensor calibration, battery replacements, and emergency on-site engineer dispatch within 4 hours.
                </p>
            </div>
            <a href="{{ route('contact') }}" class="px-6 py-3.5 rounded-xl font-bold text-xs text-slate-900 bg-teal-400 hover:bg-teal-300 transition shadow-lg shrink-0">
                Book Engineering Consultation
            </a>
        </div>
    </div>

@endsection

