@extends('layouts.public')

@section('title', 'Cart | MedTech Distributions')

@section('content')

    <div class="page-head">
        <div class="shell py-12 sm:py-16">
            <nav class="crumbs flex gap-x-2" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><span class="text-slate-700">Cart</span></nav>
            <h1 class="mt-5">Your cart</h1>
        </div>
    </div>

    <div class="shell py-14 sm:py-20">
        @if($cart->items->isEmpty())
            <div class="mx-auto max-w-lg bg-white px-8 py-12 text-center">
                <h2 class="font-display text-lg font-bold text-ink">Your cart is empty</h2>
                <p class="mt-2 text-sm text-slate-600">Add equipment from the catalogue, or send us a list and we'll quote it.</p>
                <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">
                    <a href="{{ route('products.index') }}" class="btn-primary">Browse equipment</a>
                    <a href="{{ route('quotations.create') }}" class="btn-quiet">Request a quote</a>
                </div>
            </div>
        @else
            <div class="grid items-start gap-10 lg:grid-cols-12">
                <div class="lg:col-span-8">
                    <div class="flex items-center justify-between border-b border-slate-200 pb-3 text-sm">
                        <span class="font-bold text-ink">{{ $cart->item_count }} {{ \Illuminate\Support\Str::plural('item', $cart->item_count) }}</span>
                        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Remove everything from your cart?');">
                            @csrf
                            <button type="submit" class="text-slate-500 hover:text-rose-700 hover:underline">Empty cart</button>
                        </form>
                    </div>

                    <ul class="divide-y divide-slate-200">
                        @foreach($cart->items as $item)
                            <li class="flex flex-col gap-4 py-5 sm:flex-row sm:items-center">
                                <div class="flex flex-1 items-center gap-4">
                                    <div class="flex h-20 w-20 shrink-0 items-center justify-center border border-slate-200 bg-white p-2">
                                        @if($item->product && $item->product->primary_image_url)
                                            <img src="{{ $item->product->primary_image_url }}" alt="" class="max-h-full max-w-full object-contain">
                                        @else
                                            <x-equip-art :name="$item->product?->name" />
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ $item->product ? route('products.show', $item->product->slug) : '#' }}" class="text-[15px] font-semibold text-ink hover:text-brand-700">{{ $item->product?->name ?? 'Equipment item' }}</a>
                                        <p class="mt-0.5 text-[13px] text-slate-500">SKU {{ $item->product?->sku }} &nbsp;|&nbsp; {{ number_format($item->unit_price, 2) }} {{ config('env.DEFAULT_CURRENCY', 'NGN') }} each</p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between gap-5 sm:justify-end">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <label for="qty_{{ $item->id }}" class="sr-only">Quantity</label>
                                        <input type="number" id="qty_{{ $item->id }}" name="quantity" value="{{ $item->quantity }}" min="1" max="500" class="field !w-16 !py-1.5 text-center">
                                        <button type="submit" class="text-[13px] font-semibold text-brand-700 hover:underline">Update</button>
                                    </form>
                                    <span class="w-32 text-right text-[15px] font-bold text-ink">{{ number_format($item->unit_price * $item->quantity, 2) }} {{ config('env.DEFAULT_CURRENCY', 'NGN') }}</span>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[13px] text-slate-500 hover:text-rose-700 hover:underline">Remove</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('products.index') }}" class="mt-2 inline-block text-sm font-semibold text-brand-700 hover:underline">Continue shopping</a>
                </div>

                <aside class="bg-white p-6 lg:col-span-4">
                    <h2 class="font-display text-base font-bold text-ink">Order summary</h2>
                    <dl class="mt-4 space-y-2.5 text-sm text-slate-600">
                        <div class="flex justify-between"><dt>Subtotal</dt><dd class="font-semibold text-ink">{{ number_format($subtotal, 2) }} {{ config('env.DEFAULT_CURRENCY', 'NGN') }}</dd></div>
                        @if($vatRate > 0)
                            <div class="flex justify-between"><dt>VAT ({{ $vatRate }}%)</dt><dd class="font-semibold text-ink">{{ number_format($taxAmount, 2) }} {{ config('env.DEFAULT_CURRENCY', 'NGN') }}</dd></div>
                        @endif
                        <div class="flex justify-between"><dt>Shipping</dt><dd>Added at checkout</dd></div>
                        <div class="flex items-baseline justify-between border-t border-slate-300 pt-3">
                            <dt class="font-bold text-ink">Total</dt>
                            <dd class="font-display text-xl font-bold text-ink">{{ number_format($total, 2) }} {{ config('env.DEFAULT_CURRENCY', 'NGN') }}</dd>
                        </div>
                    </dl>
                    <a href="{{ route('checkout.index') }}" class="btn-primary mt-5 w-full !py-3">Go to checkout</a>
                    <p class="mt-3 text-[13px] text-slate-500">Pay by card or bank transfer through Paystack or Flutterwave.</p>
                </aside>
            </div>
        @endif
    </div>

@endsection
