<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerPortalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuotationController;
use Illuminate\Support\Facades\Route;

// ─── Public Website Routes ───────────────────────────────────────────────────

Route::get('/', [HomeController::class, 'index'])->name('home');

// Products & Catalog
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Categories & Brands
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
Route::get('/brands/{slug}', [BrandController::class, 'show'])->name('brands.show');

// Services
Route::get('/services', [PageController::class, 'services'])->name('services.index');
Route::get('/services/{slug}', [PageController::class, 'service'])->name('services.show');

// Static Pages & Enquiries
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'enquiryStore'])->name('contact.store');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

// Quotation Requests
Route::get('/quotations/request', [QuotationController::class, 'create'])->name('quotations.create');
Route::post('/quotations/request', [QuotationController::class, 'store'])->name('quotations.store');
Route::get('/quotations/confirmed/{quotationNumber}', [QuotationController::class, 'success'])->name('quotations.success');
Route::get('/quotations/{quotationNumber}/pdf', [PdfController::class, 'quotation'])->name('quotations.pdf');

// Order Tracking & Invoices
Route::get('/orders/track', [CheckoutController::class, 'track'])->name('orders.track');
Route::get('/orders/{orderNumber}/pdf', [PdfController::class, 'invoice'])->name('orders.pdf');

// ─── E-Commerce Cart Routes ───────────────────────────────────────────────────

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'store'])->name('add');
    Route::patch('/item/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/item/{id}', [CartController::class, 'destroy'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

// ─── Checkout & Payment Routes ────────────────────────────────────────────────

Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/', [CheckoutController::class, 'store'])->name('store');
    Route::get('/callback/paystack', [CheckoutController::class, 'paystackCallback'])->name('callback.paystack');
    Route::get('/callback/flutterwave', [CheckoutController::class, 'flutterwaveCallback'])->name('callback.flutterwave');
    Route::get('/success/{orderNumber}', [CheckoutController::class, 'success'])->name('success');
});

// ─── Authenticated Customer Portal ────────────────────────────────────────────

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [CustomerPortalController::class, 'dashboard'])->name('dashboard');

    Route::prefix('portal')->name('customer.')->group(function () {
        Route::get('/orders', [CustomerPortalController::class, 'orders'])->name('orders.index');
        Route::get('/orders/{orderNumber}', [CustomerPortalController::class, 'orderShow'])->name('orders.show');
        Route::get('/quotations', [CustomerPortalController::class, 'quotations'])->name('quotations.index');
        Route::get('/quotations/{quotationNumber}', [CustomerPortalController::class, 'quotationShow'])->name('quotations.show');
        Route::get('/addresses', [CustomerPortalController::class, 'addresses'])->name('addresses.index');
        Route::post('/addresses', [CustomerPortalController::class, 'addressStore'])->name('addresses.store');
        Route::delete('/addresses/{id}', [CustomerPortalController::class, 'addressDestroy'])->name('addresses.destroy');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
