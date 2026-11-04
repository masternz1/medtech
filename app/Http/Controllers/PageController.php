<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Faq;
use App\Models\Product;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        $testimonials = Testimonial::active()->orderBy('sort_order')->get();
        return view('pages.about', compact('testimonials'));
    }

    public function services(): View
    {
        $services = Service::active()->orderBy('sort_order')->get();
        return view('pages.services', compact('services'));
    }

    public function service(string $slug): View
    {
        $service = Service::active()->where('slug', $slug)->firstOrFail();
        $otherServices = Service::active()->where('id', '!=', $service->id)->take(4)->get();
        return view('pages.service-detail', compact('service', 'otherServices'));
    }

    public function contact(Request $request): View
    {
        $selectedProduct = null;
        if ($productId = $request->query('product_id')) {
            $selectedProduct = Product::active()->find($productId);
        }

        return view('pages.contact', compact('selectedProduct'));
    }

    public function enquiryStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:50'],
            'organization' => ['nullable', 'string', 'max:255'],
            'subject'      => ['required', 'string', 'max:255'],
            'message'      => ['required', 'string', 'max:5000'],
            'product_id'   => ['nullable', 'exists:products,id'],
        ]);

        $validated['ip_address'] = $request->ip();
        $validated['status'] = 'new';

        Enquiry::create($validated);

        return back()->with('success', 'Thank you! Your enquiry has been received. Our medical specialists will respond within 24 hours.');
    }

    public function faq(): View
    {
        $faqsByCategory = Faq::active()
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');

        return view('pages.faq', compact('faqsByCategory'));
    }

    public function terms(): View
    {
        return view('pages.terms');
    }

    public function privacy(): View
    {
        return view('pages.privacy');
    }
}

