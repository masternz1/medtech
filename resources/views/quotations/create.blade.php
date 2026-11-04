@extends('layouts.public')

@section('title', 'Request Medical Equipment Quotation — MedEquip Pro')
@section('meta_description', 'Submit an institutional Request for Quotation (RFQ) for hospital equipment, ICU ventilators, monitors, and clinical systems.')

@section('content')

    <div class="bg-gradient-to-br from-slate-900 to-teal-950 text-white py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-slate-400 mb-3 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-teal-400 transition">Home</a>
                <span>/</span>
                <span class="text-white font-semibold">Request a Quote</span>
            </nav>
            <div class="max-w-2xl space-y-2">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-500/10 border border-teal-500/30 text-teal-300 text-xs font-semibold">
                    Institutional Procurement &amp; Tender Desk
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Request Formal Equipment Quotation</h1>
                <p class="text-xs sm:text-sm text-slate-300">
                    For hospitals, government tenders, clinical centres, and volume procurement. Our biomedical engineering department prepares itemized quotes with VAT, logistics, and warranty terms within 24 hours.
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12"
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
         }"
    >
        <form action="{{ route('quotations.store') }}" method="POST" class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 shadow-sm space-y-8">
            @csrf

            <!-- Section 1: Institution & Contact Details -->
            <div class="space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-teal-700">1. Healthcare Facility &amp; Contact Information</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Please specify your hospital or clinic details for formal invoice generation.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="organization_name" class="block text-xs font-semibold text-slate-700 mb-1">Healthcare Facility / Organization Name *</label>
                        <input
                            type="text"
                            id="organization_name"
                            name="organization_name"
                            value="{{ old('organization_name', auth()->user()?->profile?->organization_name) }}"
                            required
                            placeholder="e.g. Cedar Crest Specialist Hospital"
                            class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                        />
                        @error('organization_name') <span class="text-[11px] text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="contact_name" class="block text-xs font-semibold text-slate-700 mb-1">Procurement Officer / Contact Person *</label>
                        <input
                            type="text"
                            id="contact_name"
                            name="contact_name"
                            value="{{ old('contact_name', auth()->user()?->name) }}"
                            required
                            placeholder="Dr. / Pharm. / Engr. Full Name"
                            class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                        />
                        @error('contact_name') <span class="text-[11px] text-rose-500">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label for="contact_email" class="block text-xs font-semibold text-slate-700 mb-1">Official Email Address *</label>
                        <input
                            type="email"
                            id="contact_email"
                            name="contact_email"
                            value="{{ old('contact_email', auth()->user()?->email) }}"
                            required
                            placeholder="procurement@hospital.org"
                            class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                        />
                        @error('contact_email') <span class="text-[11px] text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="contact_phone" class="block text-xs font-semibold text-slate-700 mb-1">Direct Phone / WhatsApp *</label>
                        <input
                            type="text"
                            id="contact_phone"
                            name="contact_phone"
                            value="{{ old('contact_phone', auth()->user()?->profile?->phone) }}"
                            required
                            placeholder="+234 800 000 0000"
                            class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                        />
                        @error('contact_phone') <span class="text-[11px] text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="country" class="block text-xs font-semibold text-slate-700 mb-1">Country / Region *</label>
                        <input
                            type="text"
                            id="country"
                            name="country"
                            value="{{ old('country', auth()->user()?->profile?->country ?? 'Nigeria') }}"
                            required
                            class="w-full text-xs py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                        />
                        @error('country') <span class="text-[11px] text-rose-500">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Equipment Items List -->
            <div class="space-y-4">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-bold uppercase tracking-wider text-teal-700">2. Requested Medical Equipment Items</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Select from our catalog or specify custom clinical equipment models.</p>
                    </div>
                    <button
                        type="button"
                        @click="addItem()"
                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold text-teal-700 bg-teal-50 hover:bg-teal-100 border border-teal-200 rounded-lg transition"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Add Equipment Item</span>
                    </button>
                </div>

                <div class="space-y-3">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/90 grid grid-cols-1 md:grid-cols-12 gap-3 items-end relative">
                            
                            <!-- Catalog Select (4 cols) -->
                            <div class="md:col-span-4">
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Choose from Catalog</label>
                                <select
                                    :name="'items[' + index + '][product_id]'"
                                    x-model="item.product_id"
                                    @change="onProductSelect(index, $event)"
                                    class="w-full text-xs py-2 px-2.5 bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                                >
                                    <option value="">-- Custom / Unlisted Equipment --</option>
                                    @foreach($allProducts as $p)
                                        <option value="{{ $p->id }}" {{ ($selectedProduct && $selectedProduct->id === $p->id) ? 'selected' : '' }}>
                                            {{ $p->name }} ({{ $p->sku }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Name / Description (4 cols) -->
                            <div class="md:col-span-4">
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Equipment Name / Description *</label>
                                <input
                                    type="text"
                                    :name="'items[' + index + '][product_name]'"
                                    x-model="item.product_name"
                                    required
                                    placeholder="e.g. ICU Ventilator Dräger Evita V800"
                                    class="w-full text-xs py-2 px-2.5 bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                                />
                            </div>

                            <!-- Quantity (2 cols) -->
                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Qty *</label>
                                <input
                                    type="number"
                                    :name="'items[' + index + '][quantity]'"
                                    x-model="item.quantity"
                                    min="1"
                                    required
                                    class="w-full text-xs py-2 px-2.5 bg-white border border-slate-300 rounded-lg text-center focus:outline-none focus:ring-2 focus:ring-teal-500"
                                />
                            </div>

                            <!-- Action Remove (2 cols) -->
                            <div class="md:col-span-2 flex items-center justify-end">
                                <button
                                    type="button"
                                    @click="removeItem(index)"
                                    class="p-2 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition"
                                    title="Remove Item"
                                    x-show="items.length > 1"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>

                            <!-- Optional Notes -->
                            <div class="md:col-span-12">
                                <input
                                    type="text"
                                    :name="'items[' + index + '][notes]'"
                                    x-model="item.notes"
                                    placeholder="Optional specifications (e.g. adult/paediatric sensors, mobile trolley, extended warranty)..."
                                    class="w-full text-[11px] py-1.5 px-2.5 bg-white border border-slate-200 rounded-lg text-slate-600 focus:outline-none focus:ring-1 focus:ring-teal-500"
                                />
                            </div>

                        </div>
                    </template>
                </div>
            </div>

            <!-- Section 3: Special Delivery & Tender Requirements -->
            <div class="space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-teal-700">3. Tender &amp; Clinical Requirements</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Include any installation, delivery timeframe, or payment schedule requirements.</p>
                </div>

                <div>
                    <textarea
                        name="requirements"
                        rows="4"
                        placeholder="e.g. Delivery required within 14 business days to National Hospital Abuja. Include installation, electrical safety tests, 2-year AMC option, and training for 6 nurses and 2 biomedical staff..."
                        class="w-full text-xs p-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white"
                    >{{ old('requirements') }}</textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <span class="text-xs text-slate-500">
                    A copy of your RFQ submission and tracking number will be sent to your email.
                </span>
                <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-xl font-bold text-xs text-white bg-slate-900 hover:bg-teal-700 transition shadow-lg">
                    Submit Quotation Request
                </button>
            </div>

        </form>
    </div>

@endsection

