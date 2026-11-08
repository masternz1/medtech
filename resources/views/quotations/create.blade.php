@extends('layouts.public')

@section('title', 'Request a quote | MedTech Distributions')
@section('meta_description', 'Send us your equipment list and we will reply with an itemised quotation including VAT, delivery, installation and warranty terms.')

@section('content')

    <div class="page-head">
        <div class="shell py-12 sm:py-16">
            <nav class="crumbs flex gap-x-2" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><span class="text-slate-700">Request a quote</span></nav>
            <h1 class="mt-5">Request a quote</h1>
            <p class="mt-4 max-w-2xl text-sm text-slate-600">For hospitals, tenders and bulk orders. List what you need and we will send an itemised quotation with VAT, delivery, installation and warranty terms.</p>
        </div>
    </div>

    <div class="shell max-w-4xl py-14 sm:py-20"
         x-data="{
            items: [
                @if($selectedProduct)
                    { product_id: '{{ $selectedProduct->id }}', product_name: '{{ addslashes($selectedProduct->name) }}', quantity: 1, notes: '{{ addslashes($selectedProduct->sku) }}' }
                @else
                    { product_id: '', product_name: '', quantity: 1, notes: '' }
                @endif
            ],
            addItem() {
                this.items.push({ product_id: '', product_name: '', quantity: 1, notes: '' });
            },
            removeItem(index) {
                if (this.items.length > 1) {
                    this.items.splice(index, 1);
                }
            },
            onProductSelect(index, event) {
                const selectedText = event.target.options[event.target.selectedIndex].text;
                if (event.target.value) {
                    this.items[index].product_name = selectedText.split('(')[0].trim();
                }
            }
         }">
        <form action="{{ route('quotations.store') }}" method="POST" class="space-y-12">
            @csrf

            <section>
                <h2 class="sec-title mb-8">1. Who is asking</h2>
                <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="organization_name" class="label">Hospital or organisation</label>
                            <input type="text" id="organization_name" name="organization_name" value="{{ old('organization_name', auth()->user()?->profile?->organization_name) }}" required placeholder="Cedar Crest Specialist Hospital" class="field">
                            @error('organization_name')<p class="mt-1 text-[13px] text-rose-700">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="contact_name" class="label">Contact person</label>
                            <input type="text" id="contact_name" name="contact_name" value="{{ old('contact_name', auth()->user()?->name) }}" required class="field">
                            @error('contact_name')<p class="mt-1 text-[13px] text-rose-700">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="contact_email" class="label">Email</label>
                            <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', auth()->user()?->email) }}" required placeholder="procurement@hospital.org" class="field">
                            @error('contact_email')<p class="mt-1 text-[13px] text-rose-700">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="contact_phone" class="label">Phone or WhatsApp</label>
                            <input type="text" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', auth()->user()?->profile?->phone) }}" required placeholder="+234 800 000 0000" class="field">
                            @error('contact_phone')<p class="mt-1 text-[13px] text-rose-700">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="country" class="label">Country</label>
                            <input type="text" id="country" name="country" value="{{ old('country', auth()->user()?->profile?->country ?? 'Nigeria') }}" required class="field">
                            @error('country')<p class="mt-1 text-[13px] text-rose-700">{{ $message }}</p>@enderror
                        </div>
                </div>
            </section>

            <section>
                <div class="mb-4 flex items-center justify-between gap-4">
                    <h2 class="sec-title flex-1">2. What you need</h2>
                    <button type="button" @click="addItem()" class="btn-outline !py-1.5">Add another item</button>
                </div>

                <div class="divide-y divide-slate-200 border-y border-slate-200">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="grid gap-3 py-4 md:grid-cols-12">
                            <div class="md:col-span-4">
                                <label class="label">From our catalogue</label>
                                <select :name="'items[' + index + '][product_id]'" x-model="item.product_id" @change="onProductSelect(index, $event)" class="field">
                                    <option value="">Not listed / custom</option>
                                    @foreach($allProducts as $p)
                                        <option value="{{ $p->id }}" {{ ($selectedProduct && $selectedProduct->id === $p->id) ? 'selected' : '' }}>{{ $p->name }} ({{ $p->sku }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-5">
                                <label class="label">Item name or description</label>
                                <input type="text" :name="'items[' + index + '][product_name]'" x-model="item.product_name" required placeholder="For example: Dräger Evita V800" class="field">
                            </div>
                            <div class="md:col-span-2">
                                <label class="label">Quantity</label>
                                <input type="number" :name="'items[' + index + '][quantity]'" x-model="item.quantity" min="1" required class="field">
                            </div>
                            <div class="flex items-end md:col-span-1">
                                <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="py-2 text-sm text-slate-500 hover:text-rose-700 hover:underline">Remove</button>
                            </div>
                            <div class="md:col-span-12">
                                <input type="text" :name="'items[' + index + '][notes]'" x-model="item.notes" aria-label="Notes for this item" placeholder="Optional: adult or paediatric sensors, trolley, extended warranty" class="field">
                            </div>
                        </div>
                    </template>
                </div>
            </section>

            <section>
                <h2 class="sec-title mb-8">3. Delivery and other requirements</h2>
                <label for="requirements" class="sr-only">Requirements</label>
                <textarea id="requirements" name="requirements" rows="5" class="field" placeholder="For example: delivery to Abuja within 14 working days, installation and electrical safety tests, an annual maintenance contract, training for 6 nurses.">{{ old('requirements') }}</textarea>
            </section>

            <div class="flex flex-col items-start gap-4 border-t border-slate-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">A copy of your request and a reference number will be emailed to you.</p>
                <button type="submit" class="btn-primary !px-8 !py-3">Send request</button>
            </div>
        </form>
    </div>

@endsection
