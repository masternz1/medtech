<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class QuotationController extends Controller
{
    public function create(Request $request): View
    {
        $selectedProduct = null;
        if ($slug = $request->query('product')) {
            $selectedProduct = Product::active()->where('slug', $slug)->first();
        } elseif ($id = $request->query('product_id')) {
            $selectedProduct = Product::active()->find($id);
        }

        $allProducts = Product::active()
            ->orderBy('name')
            ->get(['id', 'name', 'model_number', 'sku', 'pricing_type', 'price']);

        return view('quotations.create', compact('selectedProduct', 'allProducts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'organization_name' => ['required', 'string', 'max:255'],
            'contact_name'      => ['required', 'string', 'max:255'],
            'contact_email'     => ['required', 'email', 'max:255'],
            'contact_phone'     => ['required', 'string', 'max:50'],
            'country'           => ['required', 'string', 'max:100'],
            'requirements'      => ['nullable', 'string', 'max:5000'],
            'items'             => ['required', 'array', 'min:1'],
            'items.*.product_id'=> ['nullable', 'exists:products,id'],
            'items.*.product_name' => ['required', 'string', 'max:255'],
            'items.*.quantity'  => ['required', 'integer', 'min:1', 'max:1000'],
            'items.*.notes'     => ['nullable', 'string', 'max:1000'],
        ]);

        $quotationNumber = 'QUO-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        $quotation = Quotation::create([
            'user_id'           => Auth::id(),
            'quotation_number'  => $quotationNumber,
            'status'            => Quotation::STATUS_SUBMITTED,
            'organization_name' => $validated['organization_name'],
            'contact_name'      => $validated['contact_name'],
            'contact_email'     => $validated['contact_email'],
            'contact_phone'     => $validated['contact_phone'],
            'country'           => $validated['country'],
            'requirements'      => $validated['requirements'] ?? null,
            'submitted_at'      => now(),
        ]);

        foreach ($validated['items'] as $itemData) {
            $product = !empty($itemData['product_id']) ? Product::find($itemData['product_id']) : null;
            $unitPrice = $product ? $product->price : null;
            $subtotal = ($unitPrice && $itemData['quantity']) ? $unitPrice * $itemData['quantity'] : null;

            QuotationItem::create([
                'quotation_id' => $quotation->id,
                'product_id'   => $product?->id,
                'product_name' => $itemData['product_name'],
                'quantity'     => $itemData['quantity'],
                'unit_price'   => $unitPrice,
                'subtotal'     => $subtotal,
                'notes'        => $itemData['notes'] ?? null,
            ]);
        }

        return redirect()->route('quotations.success', ['quotationNumber' => $quotationNumber])
            ->with('success', 'Your quotation request has been submitted successfully.');
    }

    public function success(string $quotationNumber): View
    {
        $quotation = Quotation::where('quotation_number', $quotationNumber)
            ->with(['items.product'])
            ->firstOrFail();

        return view('quotations.success', compact('quotation'));
    }
}

