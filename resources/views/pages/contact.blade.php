@extends('layouts.public')

@section('title', 'Contact us | MedTech Distributions')
@section('meta_description', 'Contact MedTech Distributions for quotations, datasheets, spare parts or a service visit.')

@section('content')

    <div class="page-head">
        <div class="shell py-12 sm:py-16">
            <nav class="crumbs flex gap-x-2" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><span class="text-slate-700">Contact</span></nav>
            <h1 class="mt-5">Contact us</h1>
            <p class="mt-4 max-w-2xl text-sm text-slate-600">For datasheets, pricing, spare parts or a service visit, call us or use the form.</p>
        </div>
    </div>

    <div class="shell grid gap-12 py-10 lg:grid-cols-12">

        <div class="lg:col-span-5">
            <dl class="divide-y divide-slate-200 border-y border-slate-200 text-[15px]">
                <div class="py-4">
                    <dt class="font-bold text-ink">Address</dt>
                    <dd class="mt-0.5 text-slate-600">{{ $company['address'] }}</dd>
                </div>
                @if($company['phone'])
                <div class="py-4">
                    <dt class="font-bold text-ink">Phone</dt>
                    <dd class="mt-0.5"><a href="tel:{{ preg_replace('/[^+\d]/', '', $company['phone']) }}" class="text-brand-700 hover:underline">{{ $company['phone'] }}</a></dd>
                </div>
                @endif
                @if($company['email'])
                <div class="py-4">
                    <dt class="font-bold text-ink">Email</dt>
                    <dd class="mt-0.5"><a href="mailto:{{ $company['email'] }}" class="text-brand-700 hover:underline">{{ $company['email'] }}</a></dd>
                </div>
                @endif
                @if($company['hours'])
                <div class="py-4">
                    <dt class="font-bold text-ink">Opening hours</dt>
                    <dd class="mt-0.5 text-slate-600">{{ $company['hours'] }}</dd>
                </div>
                @endif
            </dl>

            <div class="mt-6 bg-white px-5 py-4 text-sm leading-relaxed text-slate-700">
                <b class="text-ink">Visiting us?</b> Our warehouse is at the address above. Please send us a message first so we can have the right person ready.
            </div>
        </div>

        <div class="lg:col-span-7">
            <h2 class="font-display text-lg font-bold text-ink">Send us a message</h2>

            @if($selectedProduct)
                <div class="mt-3 flex items-center justify-between gap-3 bg-white px-4 py-2.5 text-sm">
                    <span>About: <b>{{ $selectedProduct->name }}</b> ({{ $selectedProduct->sku }})</span>
                    <a href="{{ route('contact') }}" class="text-brand-700 hover:underline">Remove</a>
                </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST" class="mt-5 space-y-4">
                @csrf
                @if($selectedProduct)<input type="hidden" name="product_id" value="{{ $selectedProduct->id }}">@endif

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="name" class="label">Full name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', auth()->user()?->name) }}" required class="field">
                        @error('name')<p class="mt-1 text-[13px] text-rose-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="label">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', auth()->user()?->email) }}" required class="field">
                        @error('email')<p class="mt-1 text-[13px] text-rose-700">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="phone" class="label">Phone <span class="font-normal text-slate-400">(optional)</span></label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="field">
                        @error('phone')<p class="mt-1 text-[13px] text-rose-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="organization" class="label">Hospital or company <span class="font-normal text-slate-400">(optional)</span></label>
                        <input type="text" id="organization" name="organization" value="{{ old('organization') }}" class="field">
                        @error('organization')<p class="mt-1 text-[13px] text-rose-700">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label for="subject" class="label">Subject</label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject', request('subject', ($selectedProduct ? 'Enquiry regarding ' . $selectedProduct->name : 'Equipment pricing enquiry'))) }}" required class="field">
                    @error('subject')<p class="mt-1 text-[13px] text-rose-700">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="message" class="label">Message</label>
                    <textarea id="message" name="message" rows="6" required class="field" placeholder="Model, quantity, delivery location, anything that helps us answer properly.">{{ old('message') }}</textarea>
                    @error('message')<p class="mt-1 text-[13px] text-rose-700">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="btn-primary !px-8 !py-3">Send message</button>
            </form>
        </div>
    </div>

@endsection
