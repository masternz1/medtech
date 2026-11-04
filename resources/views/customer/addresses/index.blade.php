@extends('layouts.public')

@section('title', 'Delivery Addresses — MedEquip Pro')

@section('content')

    <div class="bg-white border-b border-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-slate-500 mb-2 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Home</a>
                <span>/</span>
                <a href="{{ route('dashboard') }}" class="hover:text-teal-600 transition">Portal</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold">Addresses</span>
            </nav>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Clinical Delivery Addresses</h1>
            <p class="text-xs text-slate-500 mt-1">Manage hospital wings, clinics, and billing destination addresses.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ addModal: false }">
        
        <div class="flex justify-between items-center mb-6">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Saved Addresses ({{ $addresses->count() }})</span>
            <button @click="addModal = true" class="px-4 py-2 text-xs font-bold bg-slate-900 hover:bg-teal-700 text-white rounded-xl transition shadow-sm">
                + Add New Address
            </button>
        </div>

        @if($addresses->isEmpty())
            <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center space-y-3">
                <p class="text-sm font-bold text-slate-800">No saved addresses yet</p>
                <p class="text-xs text-slate-500">Add your hospital, surgical centre or clinic address for faster checkout.</p>
                <button @click="addModal = true" class="mt-2 px-4 py-2 text-xs font-bold bg-teal-600 text-white rounded-xl">Add Address</button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($addresses as $addr)
                    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $addr->type === 'shipping' ? 'bg-teal-50 text-teal-800' : 'bg-cyan-50 text-cyan-800' }}">
                                    {{ $addr->type }} Address
                                </span>
                                @if($addr->is_default)
                                    <span class="text-[10px] font-bold text-teal-600">Default</span>
                                @endif
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm">{{ $addr->full_name }}</h3>
                            @if($addr->company)
                                <p class="text-xs font-medium text-teal-700">{{ $addr->company }}</p>
                            @endif
                            <p class="text-xs text-slate-600 mt-2">{{ $addr->address_line_1 }}</p>
                            @if($addr->address_line_2)
                                <p class="text-xs text-slate-600">{{ $addr->address_line_2 }}</p>
                            @endif
                            <p class="text-xs text-slate-600">{{ $addr->city }}, {{ $addr->state }}</p>
                            <p class="text-xs text-slate-600">{{ $addr->country }}</p>
                            <p class="text-xs text-slate-500 pt-2">Phone: {{ $addr->phone }}</p>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex justify-end">
                            <form action="{{ route('customer.addresses.destroy', $addr->id) }}" method="POST" onsubmit="return confirm('Delete this address?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-rose-600 hover:underline">Remove</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Add Address Modal -->
        <div x-show="addModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-sm" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full space-y-4 border border-slate-200 shadow-2xl" @click.outside="addModal = false">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="font-bold text-sm text-slate-900">Add Clinical Delivery Address</h3>
                    <button @click="addModal = false" class="text-slate-400 hover:text-slate-700 font-bold">&times;</button>
                </div>

                <form action="{{ route('customer.addresses.store') }}" method="POST" class="space-y-3 text-xs">
                    @csrf
                    
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">First Name *</label>
                            <input type="text" name="first_name" required class="w-full py-2 px-3 bg-slate-50 border border-slate-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Last Name *</label>
                            <input type="text" name="last_name" required class="w-full py-2 px-3 bg-slate-50 border border-slate-300 rounded-lg">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Address Type *</label>
                            <select name="type" class="w-full py-2 px-3 bg-slate-50 border border-slate-300 rounded-lg">
                                <option value="shipping">Delivery / Shipping</option>
                                <option value="billing">Billing</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Facility / Hospital Name</label>
                            <input type="text" name="company" placeholder="Hospital Name" class="w-full py-2 px-3 bg-slate-50 border border-slate-300 rounded-lg">
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Phone Number *</label>
                        <input type="text" name="phone" required placeholder="+234..." class="w-full py-2 px-3 bg-slate-50 border border-slate-300 rounded-lg">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Address Line 1 *</label>
                        <input type="text" name="address_line_1" required placeholder="Street address or Hospital ward" class="w-full py-2 px-3 bg-slate-50 border border-slate-300 rounded-lg">
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">City *</label>
                            <input type="text" name="city" required class="w-full py-2 px-3 bg-slate-50 border border-slate-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">State *</label>
                            <input type="text" name="state" required class="w-full py-2 px-3 bg-slate-50 border border-slate-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Country *</label>
                            <input type="text" name="country" value="Nigeria" required class="w-full py-2 px-3 bg-slate-50 border border-slate-300 rounded-lg">
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_default" value="1" class="rounded text-teal-600">
                            <span>Set as default address</span>
                        </label>
                    </div>

                    <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="addModal = false" class="px-4 py-2 rounded-lg bg-slate-100 text-slate-700">Cancel</button>
                        <button type="submit" class="px-5 py-2 rounded-lg bg-slate-900 text-white font-bold hover:bg-teal-700">Save Address</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection

