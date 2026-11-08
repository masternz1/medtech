@extends('layouts.public')

@section('title', 'Privacy & Data Protection | MedTech Distributions')

@section('content')

    <div class="page-head py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-slate-500 mb-2 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-brand-600 transition">Home</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold">Privacy Policy</span>
            </nav>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Privacy Policy</h1>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white p-8 rounded-2xl border border-slate-200  space-y-6 text-xs sm:text-sm text-slate-700 leading-relaxed">
            <p>
                MedTech Distributions is committed to protecting the confidentiality of healthcare institutions, doctors, procurement officers, and hospital managers who interact with our platform.
            </p>
            <section class="space-y-2">
                <h2 class="text-base font-bold text-slate-900">Information We Collect</h2>
                <p>
                    We collect professional contact details (name, hospital/organization name, email, phone number, clinical shipping addresses) strictly for the purposes of fulfilling medical orders, preparing quotation proposals, generating VAT invoices, and dispatching biomedical engineers for installation.
                </p>
            </section>
            <section class="space-y-2">
                <h2 class="text-base font-bold text-slate-900">Payment Security</h2>
                <p>
                    All online credit/debit card transactions are processed securely via PCI-DSS compliant payment gateways (Paystack and Flutterwave). MedTech Distributions does not store your card numbers or CVV codes on our servers.
                </p>
            </section>
        </div>
    </div>

@endsection

