<?php

namespace App\Filament\Widgets;

use App\Enums\BookingStatus;
use App\Enums\OrderStatus;
use App\Models\Booking;
use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    public static ?string $heading = 'أخر الطلبات المعلقة';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;

    protected static bool $isLazy = true;

    public function table(Table $table): Table
    {
        return $table
            ->query(Order::query()
                ->where('status', OrderStatus::PENDING)
                ->orderBy('created_at', 'desc')
                ->take(10)
            )
            ->columns([
                TextColumn::make('id')
                ->label('')
                ->searchable()
                ->sortable(),
            TextColumn::make('client.name')
                ->label('اسم العميل')
                ->searchable()
                ->url(fn ($record) => url('admin/clients', ['client' => $record->client_id])),
            TextColumn::make('total')
                ->label('')
                ->sortable(),
            TextColumn::make('discount')
                ->label('')
                ->sortable(),
            TextColumn::make('status')
                ->label('حالة الطلب')
                ->searchable()
                ->formatStateUsing(fn (string $state): string => __("{$state}")),
            TextColumn::make('created_at')
                ->label('تاريخ الأنشاء')
                ->dateTime(),
            ]);
    }
}
