@extends('layouts.public')

@section('title', 'FAQ | MedTech Distributions')
@section('meta_description', 'Answers about ordering, warranty, delivery, installation and payment.')

@section('content')

    <div class="page-head">
        <div class="shell py-12 sm:py-16">
            <nav class="crumbs flex gap-x-2" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><span class="text-slate-700">FAQ</span></nav>
            <h1 class="mt-5">Frequently asked questions</h1>
        </div>
    </div>

    <div class="shell max-w-3xl py-14 sm:py-20" x-data="{ open: null }">
        @foreach($faqsByCategory as $category => $faqs)
            <h2 class="mb-2 mt-8 font-display text-lg font-bold text-brand-700 first:mt-0">{{ ucfirst($category) }}</h2>
            <div class="divide-y divide-slate-200 border-y border-slate-200">
                @foreach($faqs as $faq)
                    <div>
                        <button @click="open = (open === {{ $faq->id }} ? null : {{ $faq->id }})" :aria-expanded="open === {{ $faq->id }}" class="flex w-full items-center justify-between gap-4 py-3.5 text-left text-[15px] font-semibold text-ink hover:text-brand-700">
                            <span>{{ $faq->question }}</span>
                            <svg class="h-4 w-4 shrink-0 text-slate-400 transition-transform" :class="open === {{ $faq->id }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
                        </button>
                        <div x-show="open === {{ $faq->id }}" x-cloak class="max-w-2xl pb-4 text-[15px] leading-relaxed text-slate-600">{{ $faq->answer }}</div>
                    </div>
                @endforeach
            </div>
        @endforeach

        <p class="mt-10 text-[15px] text-slate-600">Still need an answer? <a href="{{ route('contact') }}" class="font-semibold text-brand-700 hover:underline">Contact us</a> and we'll help.</p>
    </div>

@endsection
