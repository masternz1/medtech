<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::active()
            ->topLevel()
            ->with(['children' => fn($q) => $q->active()->withCount(['products' => fn($p) => $p->active()])])
            ->withCount(['products' => fn($q) => $q->active()])
            ->orderBy('sort_order')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function show(string $slug): RedirectResponse
    {
        return redirect()->route('products.index', ['category' => $slug]);
    }
}

