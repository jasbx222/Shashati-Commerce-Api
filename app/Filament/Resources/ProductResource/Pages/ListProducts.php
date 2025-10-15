<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    public function getTabs(): array
    {
        return [
            'all' => Tab::make('الكل')
                ->badge(Product::query()->count()),
            'with-offer' => Tab::make('بدون عرض')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_offer', false))
                ->badge(Product::query()->where('is_offer', false)->count()),
            'no-offer' => Tab::make('مع عرض')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_offer', true))
                ->badge(Product::query()->where('is_offer', true)->count()),
        ];
    }
}
