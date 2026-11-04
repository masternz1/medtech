@extends('layouts.public')

@section('title', 'Frequently Asked Questions — MedEquip Pro')
@section('meta_description', 'Find answers regarding medical equipment warranties, NAFDAC certification, shipping across Nigeria, payment terms, and custom quotations.')

@section('content')

    <div class="bg-white border-b border-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-slate-500 mb-2 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Home</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold">FAQs</span>
            </nav>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Frequently Asked Questions</h1>
            <p class="text-sm text-slate-500 mt-1 max-w-2xl">
                Common questions about equipment ordering, biomedical warranties, installation and institutional payment terms.
            </p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="space-y-10" x-data="{ openFaq: null }">
            @foreach($faqsByCategory as $category => $faqs)
                <div class="space-y-4">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-teal-700 border-b border-slate-200 pb-2">
                        {{ ucfirst($category) }} Information
                    </h2>

                    <div class="space-y-3">
                        @foreach($faqs as $faq)
                            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                                <button
                                    @click="openFaq = (openFaq === {{ $faq->id }} ? null : {{ $faq->id }})"
                                    class="w-full text-left p-4 sm:p-5 flex items-center justify-between gap-4 text-xs sm:text-sm font-bold text-slate-900 hover:text-teal-700 transition"
                                >
                                    <span>{{ $faq->question }}</span>
                                    <svg
                                        class="w-4 h-4 text-slate-400 shrink-0 transition-transform duration-200"
                                        :class="{ 'rotate-180 text-teal-600': openFaq === {{ $faq->id }} }"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div
                                    x-show="openFaq === {{ $faq->id }}"
                                    x-transition
                                    class="px-5 pb-5 pt-1 text-xs text-slate-600 leading-relaxed border-t border-slate-100 bg-slate-50/50"
                                    style="display: none;"
                                >
                                    {{ $faq->answer }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-16 bg-teal-50 border border-teal-200 rounded-3xl p-8 text-center space-y-3">
            <h3 class="font-bold text-base text-teal-950">Didn't find what you are looking for?</h3>
            <p class="text-xs text-teal-800 max-w-md mx-auto">
                Our medical equipment procurement and engineering specialists are available to answer any clinical or tender question.
            </p>
            <div class="pt-2">
                <a href="{{ route('contact') }}" class="inline-flex px-5 py-2.5 rounded-xl font-bold text-xs bg-slate-900 hover:bg-teal-700 text-white transition shadow-sm">
                    Contact Medical Desk
                </a>
            </div>
        </div>
    </div>

@endsection

