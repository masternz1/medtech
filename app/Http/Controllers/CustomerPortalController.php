<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Quotation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomerPortalController extends Controller
{
    public function dashboard(): View
    {
        $user = Auth::user();
        $recentOrders = $user->orders()->with(['items.product', 'shippingMethod'])->latest()->take(5)->get();
        $recentQuotations = $user->quotations()->with(['items'])->latest()->take(5)->get();
        $totalOrdersCount = $user->orders()->count();
        $totalQuotationsCount = $user->quotations()->count();

        return view('customer.dashboard', compact(
            'user',
            'recentOrders',
            'recentQuotations',
            'totalOrdersCount',
            'totalQuotationsCount'
        ));
    }

    public function orders(): View
    {
        $orders = Auth::user()->orders()
            ->with(['items.product', 'shippingMethod'])
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function orderShow(string $orderNumber): View
    {
        $order = Auth::user()->orders()
            ->where('order_number', $orderNumber)
            ->with(['items.product', 'shippingMethod', 'payments'])
            ->firstOrFail();

        return view('customer.orders.show', compact('order'));
    }

    public function quotations(): View
    {
        $quotations = Auth::user()->quotations()
            ->with(['items'])
            ->latest()
            ->paginate(10);

        return view('customer.quotations.index', compact('quotations'));
    }

    public function quotationShow(string $quotationNumber): View
    {
        $quotation = Auth::user()->quotations()
            ->where('quotation_number', $quotationNumber)
            ->with(['items.product', 'documents'])
            ->firstOrFail();

        return view('customer.quotations.show', compact('quotation'));
    }

    public function addresses(): View
    {
        $addresses = Auth::user()->addresses()->latest()->get();
        return view('customer.addresses.index', compact('addresses'));
    }

    public function addressStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type'        => ['required', 'in:shipping,billing'],
            'first_name'  => ['required', 'string', 'max:100'],
            'last_name'   => ['required', 'string', 'max:100'],
            'company'     => ['nullable', 'string', 'max:150'],
            'phone'       => ['required', 'string', 'max:50'],
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city'        => ['required', 'string', 'max:100'],
            'state'       => ['required', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country'     => ['required', 'string', 'max:100'],
            'is_default'  => ['nullable', 'boolean'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_default'] = $request->boolean('is_default');

        if ($validated['is_default']) {
            Auth::user()->addresses()->where('type', $validated['type'])->update(['is_default' => false]);
        }

        Address::create($validated);

        return back()->with('success', 'Address added successfully.');
    }

    public function addressDestroy(int $id): RedirectResponse
    {
        $address = Auth::user()->addresses()->where('id', $id)->firstOrFail();
        $address->delete();

        return back()->with('success', 'Address removed successfully.');
    }
}

