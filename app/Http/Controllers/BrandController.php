<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function index(): View
    {
        $brands = Brand::active()
            ->withCount(['products' => fn($q) => $q->active()])
            ->orderBy('sort_order')
            ->get();

        return view('brands.index', compact('brands'));
    }

    public function show(string $slug): RedirectResponse
    {
        return redirect()->route('products.index', ['brand' => $slug]);
    }
}

