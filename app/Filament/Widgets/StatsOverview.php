<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatus;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('عدد العملاء', Client::where('is_confirmed', true)->count())
                ->description(' عدد  حسابات العملاء الذين اكدو حساباتهم')
                ->descriptionIcon('heroicon-o-users', IconPosition::Before)
                ->descriptionColor('warining')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->chartColor('warining'),

            Stat::make('عددالطلبات المكتملة', Order::where('status', OrderStatus::COMPLETED)->count())
                ->description('عدد الطلبات التي تم تسليمها')
                ->descriptionColor('success')
                ->descriptionIcon('heroicon-o-shopping-bag', IconPosition::Before)
                ->chart(['100', '60', '40', '20', '10', '5'])
                ->chartColor('success'),

            Stat::make('عدد المنتجات', Product::count())
                ->description('عدد المنتجات الموجودين على المنصة')
                ->descriptionIcon('heroicon-o-chart-bar', IconPosition::Before)
                ->descriptionColor('warining')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->chartColor('warining'),

            Stat::make('اجمالي المبيعات المقبوضة', Order::where('status', OrderStatus::COMPLETED)->sum('total'))
                ->description(' اجمالي المبالغ المقبوضة من الطلبات المكتملة')
                ->descriptionIcon('heroicon-o-banknotes', IconPosition::Before)
                ->descriptionColor('success')
                ->chart(['100', '60', '40', '20', '10', '5'])
                ->chartColor('success'),
        ];
    }
}
