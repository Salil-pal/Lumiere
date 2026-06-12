<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make('Total Orders', Order::count()),

            Stat::make(
                'Total Revenue',
                '$' . number_format(
                    Order::where('status', 'paid')->sum('total'),
                    2
                )
            ),

            Stat::make('Products', Product::count()),

            Stat::make(
                'Low Stock Products',
                Product::where('stock', '<=', 5)->count()
            ),
        ];
    }
}