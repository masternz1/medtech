<?php

namespace App\Filament\Widgets;

use App\Models\Inventory;
use App\Models\Order;
use App\Models\Product;
use App\Models\Quotation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $paidRevenue = Order::where('payment_status', 'paid')->sum('total');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $pendingQuotes = Quotation::whereIn('status', ['submitted', 'under_review'])->count();
        $activeProducts = Product::active()->count();
        $lowStockCount = Inventory::whereColumn('quantity', '<=', 'low_stock_threshold')->count();

        return [
            Stat::make('Total Revenue', number_format($paidRevenue, 2) . ' ' . config('env.DEFAULT_CURRENCY', 'NGN'))
                ->description("{$totalOrders} Total Orders ({$pendingOrders} pending)")
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Pending Quotations', (string) $pendingQuotes)
                ->description('RFQs requiring biomedical pricing')
                ->descriptionIcon('heroicon-m-document-text')
                ->color($pendingQuotes > 0 ? 'warning' : 'gray'),

            Stat::make('Active Medical Catalog', (string) $activeProducts)
                ->description("{$lowStockCount} items at low stock")
                ->descriptionIcon('heroicon-m-cube')
                ->color($lowStockCount > 0 ? 'danger' : 'info'),
        ];
    }
}

