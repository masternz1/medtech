@extends('layouts.public')

@section('title', 'Delivery addresses | MedTech Distributions')

@section('content')

    <div class="page-head">
        <div class="shell py-12 sm:py-16"><h1>Delivery addresses</h1><p class="mt-4 text-sm text-slate-500">Saved addresses are offered at checkout.</p></div>
    </div>

    <div class="shell py-6" x-data="{ addModal: false }" @keydown.escape.window="addModal = false">
        @include('customer._nav')

        <div class="mb-5 mt-6 flex items-center justify-between">
            <p class="text-sm text-slate-500">{{ $addresses->count() }} saved</p>
            <button @click="addModal = true" class="btn-primary">Add an address</button>
        </div>

        @if($addresses->isEmpty())
            <div class="py-14 text-center">
                <p class="font-bold text-ink">No saved addresses yet</p>
                <p class="mt-1 text-sm text-slate-500">Add your hospital or clinic address to speed up checkout.</p>
            </div>
        @else
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach($addresses as $addr)
                    <div class="panel flex flex-col p-5 text-sm">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="font-semibold capitalize text-slate-500">{{ $addr->type }}</span>
                            @if($addr->is_default)<span class="border border-brand-600 px-1.5 text-xs font-semibold text-brand-700">Default</span>@endif
                        </div>
                        <address class="not-italic leading-relaxed text-slate-600">
                            <b class="text-ink">{{ $addr->full_name }}</b><br>
                            @if($addr->company){{ $addr->company }}<br>@endif
                            {{ $addr->address_line_1 }}<br>
                            @if($addr->address_line_2){{ $addr->address_line_2 }}<br>@endif
                            {{ $addr->city }}, {{ $addr->state }}, {{ $addr->country }}<br>
                            {{ $addr->phone }}
                        </address>
                        <form action="{{ route('customer.addresses.destroy', $addr->id) }}" method="POST" onsubmit="return confirm('Delete this address?');" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-slate-500 hover:text-rose-700 hover:underline">Remove</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif

        <div x-show="addModal" x-cloak class="fixed inset-0 z-50 flex items-start justify-center overflow-y-auto bg-ink/50 p-4 sm:items-center" role="dialog" aria-modal="true" aria-labelledby="addr-title">
            <div @click.outside="addModal = false" class="w-full max-w-lg bg-white p-6">
                <div class="mb-4 flex items-center justify-between">
                    <h2 id="addr-title" class="font-display text-lg font-bold text-ink">Add an address</h2>
                    <button @click="addModal = false" class="text-2xl leading-none text-slate-400 hover:text-ink" aria-label="Close">&times;</button>
                </div>
                <form action="{{ route('customer.addresses.store') }}" method="POST" class="grid gap-4 sm:grid-cols-2">
                    @csrf
                    <div><label for="a_first" class="label">First name</label><input id="a_first" type="text" name="first_name" required class="field"></div>
                    <div><label for="a_last" class="label">Last name</label><input id="a_last" type="text" name="last_name" required class="field"></div>
                    <div><label for="a_type" class="label">Type</label>
                        <select id="a_type" name="type" class="field"><option value="shipping">Delivery</option><option value="billing">Billing</option></select></div>
                    <div><label for="a_company" class="label">Hospital or company</label><input id="a_company" type="text" name="company" class="field"></div>
                    <div class="sm:col-span-2"><label for="a_phone" class="label">Phone</label><input id="a_phone" type="text" name="phone" required placeholder="+234..." class="field"></div>
                    <div class="sm:col-span-2"><label for="a_addr" class="label">Street address</label><input id="a_addr" type="text" name="address_line_1" required placeholder="Street, building or ward" class="field"></div>
                    <div><label for="a_city" class="label">City</label><input id="a_city" type="text" name="city" required class="field"></div>
                    <div><label for="a_state" class="label">State</label><input id="a_state" type="text" name="state" required class="field"></div>
                    <div class="sm:col-span-2"><label for="a_country" class="label">Country</label><input id="a_country" type="text" name="country" value="Nigeria" required class="field"></div>
                    <label class="flex items-center gap-2 text-sm text-slate-700 sm:col-span-2"><input type="checkbox" name="is_default" value="1" class="rounded-sm text-brand-600 focus:ring-brand-600"> Use as my default address</label>
                    <div class="flex justify-end gap-3 sm:col-span-2">
                        <button type="button" @click="addModal = false" class="btn-quiet">Cancel</button>
                        <button type="submit" class="btn-primary">Save address</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
