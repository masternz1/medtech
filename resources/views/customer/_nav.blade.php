{{-- Account sub-navigation, used on every customer page --}}
<nav class="flex gap-6 overflow-x-auto border-b border-slate-200 text-[15px] font-semibold" aria-label="Account">
    @foreach([
        ['Overview', route('dashboard'), 'dashboard'],
        ['Orders', route('customer.orders.index'), 'customer.orders.*'],
        ['Quotations', route('customer.quotations.index'), 'customer.quotations.*'],
        ['Addresses', route('customer.addresses.index'), 'customer.addresses.*'],
        ['Profile', route('profile.edit'), 'profile.*'],
    ] as [$label, $href, $pattern])
        <a href="{{ $href }}" class="-mb-px whitespace-nowrap border-b-2 py-3 {{ request()->routeIs($pattern) ? 'border-brand-600 text-brand-700' : 'border-transparent text-slate-500 hover:text-ink' }}">{{ $label }}</a>
    @endforeach
</nav>
