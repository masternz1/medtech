@extends('layouts.public')

@section('title', 'Terms of Supply & Warranty — MedEquip Pro')

@section('content')

    <div class="bg-white border-b border-slate-200 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-slate-500 mb-2 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Home</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold">Terms of Supply</span>
            </nav>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Terms of Supply &amp; Clinical Equipment Warranty</h1>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6 text-xs sm:text-sm text-slate-700 leading-relaxed">
            <section class="space-y-2">
                <h2 class="text-base font-bold text-slate-900">1. Acceptance of Medical Equipment Terms</h2>
                <p>
                    By placing an order or requesting a formal quotation with MedEquip Pro, you acknowledge that all products supplied are intended for clinical, hospital, diagnostic, laboratory, or healthcare training use by qualified healthcare practitioners.
                </p>
            </section>

            <section class="space-y-2">
                <h2 class="text-base font-bold text-slate-900">2. Warranty &amp; Technical Support</h2>
                <p>
                    All medical devices carry OEM warranties against manufacturing defects for the period specified on the respective product invoice or quotation (typically 1 to 3 years). Warranty covers genuine parts and authorized factory service. It does not cover damage caused by unauthorized modifications, electrical surges without approved voltage regulation, physical impact, or use of incompatible non-OEM consumables.
                </p>
            </section>

            <section class="space-y-2">
                <h2 class="text-base font-bold text-slate-900">3. Commissioning &amp; Handover</h2>
                <p>
                    For intensive care ventilators, patient monitoring networks, and diagnostic systems where professional commissioning is purchased, warranty begins upon signing of the Biomedical Handover &amp; Calibration Certificate.
                </p>
            </section>

            <section class="space-y-2">
                <h2 class="text-base font-bold text-slate-900">4. Returns &amp; Discrepancies</h2>
                <p>
                    Discrepancies in shipment or transit damages must be documented upon arrival and reported within 7 business days. Due to hygiene, regulatory sterility protocols, and infection control standards, sterile consumables cannot be returned once opened.
                </p>
            </section>
        </div>
    </div>

@endsection

