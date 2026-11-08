@extends('layouts.public')

@section('title', 'Installation, maintenance and spare parts | MedTech Distributions')
@section('meta_description', 'Installation, commissioning, preventive maintenance, calibration, staff training and genuine spare parts for ventilators and critical-care equipment.')

@section('content')

    <div class="page-head">
        <div class="shell py-12 sm:py-16">
            <nav class="crumbs flex gap-x-2" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><span class="text-slate-700">Services</span></nav>
            <h1 class="mt-5">Installation, maintenance and spare parts</h1>
            <p class="mt-4 max-w-2xl text-sm text-slate-600">Our biomedical engineers look after equipment from delivery through its working life.</p>
        </div>
    </div>

    <div class="shell py-14 sm:py-20">
        <div class="grid gap-x-10 gap-y-9 md:grid-cols-2 lg:grid-cols-3">
            @foreach($services as $service)
                <div class="flex flex-col border-t-2 border-brand-600 pt-4">
                    <h2 class="font-display text-lg font-bold text-ink"><a href="{{ route('services.show', $service->slug) }}" class="hover:text-brand-700">{{ $service->title }}</a></h2>
                    <p class="mt-2 text-[15px] leading-relaxed text-slate-600">{{ $service->description }}</p>
                    <a href="{{ route('contact', ['subject' => 'Service enquiry: ' . $service->title]) }}" class="mt-3 text-sm font-semibold text-brand-700 hover:underline">Ask about this service</a>
                </div>
            @endforeach
        </div>

        <div class="mt-14 flex flex-col items-start justify-between gap-4 bg-white px-6 py-7 sm:flex-row sm:items-center sm:px-10">
            <div class="max-w-xl">
                <h2 class="font-display text-lg font-bold text-ink">Maintenance contracts</h2>
                <p class="mt-1 text-sm leading-relaxed text-slate-700">We can set up scheduled visits for sensor calibration, battery replacement and safety checks, with a call-out when something fails. Tell us what you run and we will propose a plan.</p>
            </div>
            <a href="{{ route('contact', ['subject' => 'Maintenance contract enquiry']) }}" class="btn-primary shrink-0">Talk to an engineer</a>
        </div>
    </div>

@endsection
