<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::active()
            ->with(['category', 'brand', 'primaryImage', 'inventory']);

        // Search query
        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('model_number', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Category filter
        $currentCategory = null;
        if ($catSlug = $request->input('category')) {
            $currentCategory = Category::where('slug', $catSlug)->first();
            if ($currentCategory) {
                $query->where('category_id', $currentCategory->id);
            }
        }

        // Brand filter
        $currentBrand = null;
        if ($brandSlug = $request->input('brand')) {
            $currentBrand = Brand::where('slug', $brandSlug)->first();
            if ($currentBrand) {
                $query->where('brand_id', $currentBrand->id);
            }
        }

        // Pricing type filter
        if ($pricingType = $request->input('pricing_type')) {
            $query->where('pricing_type', $pricingType);
        }

        // In-stock only filter
        if ($request->boolean('in_stock')) {
            $query->inStock();
        }

        // Price range
        if ($minPrice = $request->input('min_price')) {
            $query->where('price', '>=', (float) $minPrice);
        }
        if ($maxPrice = $request->input('max_price')) {
            $query->where('price', '<=', (float) $maxPrice);
        }

        // Sorting
        $sort = $request->input('sort', 'newest');
        match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc'   => $query->orderBy('name', 'asc'),
            'featured'   => $query->orderByDesc('is_featured')->latest(),
            default      => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        // Data for sidebar filters
        $categories = Category::active()
            ->withCount(['products' => fn($q) => $q->active()])
            ->orderBy('name')
            ->get();

        $brands = Brand::active()
            ->withCount(['products' => fn($q) => $q->active()])
            ->orderBy('name')
            ->get();

        return view('products.index', compact(
            'products',
            'categories',
            'brands',
            'currentCategory',
            'currentBrand',
            'sort'
        ));
    }

    public function show(string $slug): View
    {
        $product = Product::active()
            ->where('slug', $slug)
            ->with([
                'category',
                'brand',
                'images',
                'specifications',
                'documents',
                'inventory'
            ])
            ->firstOrFail();

        // Increment view count
        $product->increment('views_count');

        // Group specifications by group_name
        $specificationsByGroup = $product->specifications
            ->groupBy(fn($spec) => $spec->group_name ?: 'General Specifications');

        // Related products in same category
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['brand', 'primaryImage', 'inventory'])
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'specificationsByGroup', 'relatedProducts'));
    }
}

