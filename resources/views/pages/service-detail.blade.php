@extends('layouts.public')

@section('title', $service->title . ' | MedTech Distributions')

@section('content')

    <div class="page-head">
        <div class="shell py-12 sm:py-16">
            <nav class="crumbs flex flex-wrap gap-x-2" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span>/</span>
                <a href="{{ route('services.index') }}">Services</a><span>/</span>
                <span class="text-slate-700">{{ $service->title }}</span>
            </nav>
            <h1 class="mt-5">{{ $service->title }}</h1>
        </div>
    </div>

    <div class="shell grid gap-12 py-10 lg:grid-cols-12">
        <div class="lg:col-span-8">
            <p class="max-w-2xl text-[16px] leading-relaxed text-slate-700">{{ $service->description }}</p>

            <h2 class="mb-3 mt-8 font-display text-base font-bold text-ink">What you get</h2>
            <ul class="max-w-2xl space-y-2 text-[15px] text-slate-700">
                <li class="flex gap-3"><span class="mt-2 h-1.5 w-1.5 shrink-0 bg-brand-600"></span>A written record of what was done, including calibration logs.</li>
                <li class="flex gap-3"><span class="mt-2 h-1.5 w-1.5 shrink-0 bg-brand-600"></span>Electrical safety and function testing with certified test equipment.</li>
                <li class="flex gap-3"><span class="mt-2 h-1.5 w-1.5 shrink-0 bg-brand-600"></span>A short report with recommendations for anything that needs attention.</li>
                <li class="flex gap-3"><span class="mt-2 h-1.5 w-1.5 shrink-0 bg-brand-600"></span>Access to genuine spare parts and replacement modules.</li>
            </ul>

            <a href="{{ route('contact', ['subject' => 'Service booking: ' . $service->title]) }}" class="btn-primary mt-8 !py-3">Book a visit</a>
        </div>

        <aside class="space-y-8 lg:col-span-4">
            <div>
                <h2 class="mb-2 font-display text-base font-bold text-ink">Other services</h2>
                <ul class="divide-y divide-slate-200 border-y border-slate-200 text-[15px]">
                    @foreach($otherServices as $other)
                        <li><a href="{{ route('services.show', $other->slug) }}" class="block py-2.5 text-slate-700 hover:text-brand-700">{{ $other->title }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="border border-slate-200 px-5 py-4 text-[15px] leading-relaxed text-slate-700">
                <b class="text-ink">Need someone urgently?</b>
                <p class="mt-1">@if($company['phone'])Phone our team on <a href="tel:{{ preg_replace('/[^+\d]/', '', $company['phone']) }}" class="font-semibold text-brand-700 hover:underline">{{ $company['phone'] }}</a>.@else<a href="{{ route('contact') }}" class="font-semibold text-brand-700 hover:underline">Send us a message</a> and we will respond.@endif</p>
            </div>
        </aside>
    </div>

@endsection
