<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredCategories = Category::active()
            ->topLevel()
            ->withCount('products')
            ->orderBy('sort_order')
            ->take(9)
            ->get();

        $featuredProducts = Product::active()
            ->featured()
            ->with(['category', 'brand', 'primaryImage', 'inventory'])
            ->take(10)
            ->get();

        $newArrivals = Product::active()
            ->new()
            ->with(['category', 'brand', 'primaryImage', 'inventory'])
            ->take(4)
            ->get();

        $featuredBrands = Brand::active()
            ->featured()
            ->orderBy('sort_order')
            ->take(12)
            ->get();

        $services = Service::active()
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $testimonials = Testimonial::active()
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        $latestArticles = BlogPost::published()
            ->latest('published_at')
            ->take(3)
            ->get();

        $heroBanners = Banner::active()
            ->position('hero')
            ->orderBy('sort_order')
            ->get();

        return view('home', compact(
            'featuredCategories',
            'featuredProducts',
            'newArrivals',
            'featuredBrands',
            'services',
            'testimonials',
            'latestArticles',
            'heroBanners'
        ));
    }
}

