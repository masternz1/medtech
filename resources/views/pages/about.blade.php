@extends('layouts.public')

@section('title', 'About MedTech Distributions')
@section('meta_description', 'MedTech Distributions Ltd is a Lagos-based dealer in all types of medical equipment.')

@section('content')

    <div class="page-head">
        <div class="shell py-12 sm:py-16">
            <nav class="crumbs flex gap-x-2" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><span class="text-slate-700">About us</span></nav>
            <h1 class="mt-5 max-w-2xl">Dealers in all types of medical equipment</h1>
        </div>
    </div>

    <div class="shell grid gap-14 py-16 lg:grid-cols-12 lg:gap-20 sm:py-20">
        <div class="space-y-4 text-[15px] leading-relaxed text-slate-700 lg:col-span-6">
            <p>{{ $siteSettings['about_text'] ?? 'MedTech Distributions Ltd is a Lagos-based dealer in medical equipment for hospitals, clinics and diagnostic centres.' }}</p>
            <p>Our range covers ultrasound systems, CT scanners, X-ray machines, MRI machines, mammography, ventilators, vital sign monitors, dialysis machines and laboratory analyzers.</p>
            <p>Tell us what your facility needs and we will quote it, deliver it and help with installation.</p>
            <div class="flex gap-3 pt-2">
                <a href="{{ route('quotations.create') }}" class="btn-primary">Request a quote</a>
                <a href="{{ route('contact') }}" class="btn-quiet">Contact us</a>
            </div>
        </div>

        <div class="lg:col-span-6">
            <h2 class="mb-3 font-display text-base font-bold text-ink">What we deal in</h2>
            <ul class="grid gap-x-8 border-t border-slate-200 sm:grid-cols-2">
                @foreach(['Ultrasound systems', 'CT scanners', 'X-ray machines', 'MRI machines', 'Mammography', 'Ventilators', 'Vital sign monitors', 'Dialysis machines', 'Analyzers'] as $item)
                    <li class="flex items-center gap-3 border-b border-slate-200 py-3 text-[15px] font-semibold text-slate-800"><span class="h-2 w-2 shrink-0 bg-brand-600"></span>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <section class="bg-white py-12">
        <div class="shell">
            <h2 class="sec-title mb-6">Who we supply</h2>
            <div class="grid gap-x-10 gap-y-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach([
                    ['Hospitals', 'Ventilators, patient monitors and dialysis machines.'],
                    ['Clinics and laboratories', 'Analyzers, monitors and ultrasound for clinics and labs.'],
                    ['Diagnostic and imaging centres', 'Ultrasound, X-ray, CT, MRI and mammography systems.'],
                ] as [$who, $what])
                    <div class="border-t-2 border-brand-600 pt-3">
                        <h3 class="text-[15px] font-bold text-ink">{{ $who }}</h3>
                        <p class="mt-1 text-sm leading-relaxed text-slate-600">{{ $what }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @if($testimonials->isNotEmpty())
        <section class="shell py-12">
            <h2 class="sec-title mb-6">What customers say</h2>
            <div class="grid gap-8 md:grid-cols-2">
                @foreach($testimonials as $t)
                    <figure>
                        <blockquote class="text-[15px] leading-relaxed text-slate-700">&ldquo;{{ $t->content }}&rdquo;</blockquote>
                        <figcaption class="mt-2 text-sm"><b class="text-ink">{{ $t->name }}</b>, <span class="text-slate-500">{{ $t->title }}, {{ $t->organization }}</span></figcaption>
                    </figure>
                @endforeach
            </div>
        </section>
    @endif

@endsection
