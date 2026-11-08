<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
use App\Services\CartService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CartService::class, fn () => new CartService());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Implicitly grant "super_admin" role all permissions
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });

        // Share common data with public layout and header
        View::composer('*', function ($view) {
            // Computed once per request, then reused by every view (child pages, partials and layouts).
            static $shared = null;
            if ($shared !== null) {
                $view->with($shared);
                return;
            }

            if (Schema::hasTable('settings')) {
                $settings = Setting::all()->pluck('value', 'key')->toArray();
            } else {
                $settings = [];
            }

            if (Schema::hasTable('categories')) {
                $navCategories = Category::active()->topLevel()->withCount('products')->orderBy('sort_order')->take(10)->get();
            } else {
                $navCategories = collect();
            }

            $cartCount = 0;
            if (Schema::hasTable('carts')) {
                try {
                    $cartCount = app(CartService::class)->getItemCount();
                } catch (\Throwable $e) {
                    $cartCount = 0;
                }
            }

            // Company details with placeholder values filtered out, so the site never shows a fake phone or email.
            $placeholders = ['', 'MedEquip Pro', '+234 000 000 0000', 'info@medequippro.com', 'info@yourdomain.com', 'Victoria Island, Lagos, Nigeria', 'Your Company Name'];
            $pick = function (string $key, ?string $default = null) use ($settings, $placeholders) {
                $value = trim((string) ($settings[$key] ?? ''));
                return in_array($value, $placeholders, true) ? $default : $value;
            };
            $company = [
                'name'     => $pick('company_name', 'MedTech Distributions Ltd'),
                'tagline'  => $pick('company_tagline', 'Dealers in all types of medical equipment'),
                'phone'    => $pick('company_phone'),
                'whatsapp' => $pick('company_whatsapp'),
                'email'    => $pick('company_email'),
                'address'  => $pick('company_address', 'Bethel Ultra Modern Plaza, Stes 113/107, 117 Shasha Rd, Doremeta Bus Stop, Akowonjo, Lagos'),
                'hours'    => $pick('business_hours'),
            ];

            $shared = [
                'company'       => $company,
                'siteSettings'  => $settings,
                'navCategories' => $navCategories,
                'cartCount'     => $cartCount,
            ];

            $view->with($shared);
        });
    }
}
