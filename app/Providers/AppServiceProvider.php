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
        View::composer(['layouts.public', 'layouts.navigation', 'home', 'products.*'], function ($view) {
            if (Schema::hasTable('settings')) {
                $settings = Setting::all()->pluck('value', 'key')->toArray();
            } else {
                $settings = [];
            }

            if (Schema::hasTable('categories')) {
                $navCategories = Category::active()->topLevel()->withCount('products')->orderBy('sort_order')->take(8)->get();
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

            $view->with([
                'siteSettings'  => $settings,
                'navCategories' => $navCategories,
                'cartCount'     => $cartCount,
            ]);
        });
    }
}
