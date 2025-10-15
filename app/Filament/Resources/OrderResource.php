<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $pluralModelLabel = 'الطلبات';

    protected static ?string $modelLabel = 'الطلب';
  protected static ?string $navigationGroup = 'العملاء';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('رقم الطلب')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('client.name')
                    ->label('اسم العميل')
                    ->searchable()
                    ->color('primary')
                    ->url(fn ($record) => url('admin/clients', ['client' => $record->client_id])),
                TextColumn::make('total')
                    ->label('اجمالي')
                    ->sortable(),
                TextColumn::make('delivery_price')
                    ->label('التوصيل')
                    ->sortable(),
                TextColumn::make('total_with_delivery_price')
                    ->label('إجمالي مع توصيل')
                    ->sortable(),
                TextColumn::make('discount')
                    ->label('')
                    ->sortable(),
              TextColumn::make('status')
    ->label('حالة الطلب')
    ->color(function ($state) {
        switch ($state) {
            case 'pending':
                return 'warning';
            case 'accepted':
                return 'success';
            case 'completed':
                return 'primary';
            case 'returned':
                return 'danger';
            case 'cancelled':
                return 'secondary';
            default:
                return 'gray';
        }
    })
    ->searchable()
    ->formatStateUsing(function (string $state): string {
        return match ($state) {
            'pending'   => 'جاري التجهيز',
            'accepted'  => 'تم القبول',
            'completed' => 'تم الإنجاز',
            'returned'  => 'تم الإرجاع',
            'cancelled' => 'ملغي',
            default     => $state,
        };
    }),

                TextColumn::make('created_at')
                    ->label('تاريخ الأنشاء')
                    ->date(),
                ])->defaultSort('created_at', 'desc')
                ->filters([
                    SelectFilter::make('client.name')
                        ->label('العميل')
                        ->relationship('client', 'name'),
                    SelectFilter::make('status')
                        ->label('حالة الطلب')
                        ->options([
                            OrderStatus::PENDING=> 'جاري التجهيز ',
                            OrderStatus::ACCEPTED => 'مقبول',
                            OrderStatus::RETURNED => 'مسترجع',
                            OrderStatus::COMPLETED => 'مكتمل',
                            OrderStatus::CANCELLED => 'ملغى',
                        ]),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('من تاريخ:'),
                        DatePicker::make('created_until')
                            ->label('إلى تاريخ:'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                })->indicateUsing(function (array $data): array {
                    $indicators = [];

                    if ($data['created_from'] ?? null) {
                        $indicators[] = Indicator::make('من تاريخ:' . Carbon::parse($data['created_from'])->toFormattedDateString())
                            ->removeField('created_from');
                    }

                    if ($data['created_until'] ?? null) {
                        $indicators[] = Indicator::make('إلى تاريخ:' . Carbon::parse($data['created_until'])->toFormattedDateString())
                            ->removeField('created_until');
                    }

                    return $indicators;
                })
            ])->filtersTriggerAction(
                fn (Action $action) => $action
                    ->button()
                    ->slideOver()
                    ->label('تصفية'),
            )
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                ->form([
                    Select::make('status') // Create a dropdown to select the status
                        ->label('حالة الطلب') // Set the label for the status field
                        ->options([
                            'pending' => 'جاري التجهيز',
                            'accepted' => 'مقبول',
                            'returned' => 'مسترجع',
                            'completed' => 'مكتمل',
                            'cancelled' => 'ملغى',
                        ])
                        ->required(), // Make sure to require the status field
                ])
                ->modalHeading('تعديل حالة الطلب') // Heading of the modal
                ->modalAlignment(Alignment::Center) // Align the modal to the center
                ->modalWidth(MaxWidth::Large) // Set the width of the modal
                ->after(function ($record, array $data) {
                    // After saving the new status, you can execute any additional actions if needed
                    $record->update([
                        'status' => $data['status'],
                    ]);
                })
                ->action(function ($record) {
                    // You can optionally show some data or perform other actions before the modal is shown
                    return $record;
                })
                ->button('تعديل حالة الطلب'), // Label for the button
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            // Order Details Section
            Components\Section::make('تفاصيل الطلب')
                ->schema([
                    Components\Grid::make(3)
                        ->schema([
                            Components\TextEntry::make('client.name')
                                ->label('اسم العميل')
                                ->color('primary')
                                ->url(fn ($record) => url('admin/clients', ['client' => $record->client_id]))
                                ->columnSpan(1),

                            Components\TextEntry::make('client.email')
                                ->label('البريد الإلكتروني')
                                ->columnSpan(1),

                            Components\TextEntry::make('created_at')
                                ->label('تاريخ الإنشاء')
                                ->badge()
                                ->date()
                                ->color('success')
                                ->columnSpan(1),
                                Components\TextEntry::make('status')
                                ->label('حالة الطلب')
                                ->badge()
                                ->color(function ($state) {
                                    // Change the badge color based on the order status
                                    switch ($state) {
                                        case 'pending':
                                            return 'warning'; // Yellow for "pending"
                                        case 'accepted':
                                            return 'success'; // Green for "accepted"
                                        case 'completed':
                                            return 'primary'; // Blue for "completed"
                                        case 'returned':
                                            return 'danger'; // Red for "returned"
                                        case 'cancelled':
                                            return 'secondary'; // Grey for "cancelled"
                                        default:
                                            return 'gray'; // Default color
                                    }
                                })
                                ->formatStateUsing(fn (string $state): string => __("{$state}"))
                                ->columnSpan(1),
                            

                            Components\TextEntry::make('total')
                                ->label('الإجمالي')
                                ->badge()
                                ->color('success')
                                ->columnSpan(1),

                            Components\TextEntry::make('discount')
                                ->label('الخصم')
                                ->badge()
                                ->color('warning')
                                ->columnSpan(1),

                            Components\TextEntry::make('delivery_price')
                                ->label('سعر التوصيل')
                                ->badge()
                                ->color('success')
                                ->columnSpan(1),

                            Components\TextEntry::make('total_with_delivery_price')
                                ->label('الإجمالي مع التوصيل')
                                ->badge()
                                ->color('success')
                                ->columnSpan(1),
                        ]),
                ])
                ->columns(1)
                ->collapsible(),

            // Address Section
            Components\Section::make('عنوان الطلب')
                ->schema([
                    Components\Grid::make(2)
                        ->schema([
                            Components\TextEntry::make('address.governorate.name')
                                ->label('المحافظة')
                                ->color('warning')
                                ->columnSpan(1),
            
                            TextEntry::make('name')
                                ->label('العنوان كتابة')
                                ->columnSpan(1),
            
                            Components\Actions::make([
                                Components\Actions\Action::make('viewOnMap')
                                    ->label('عرض على الخريطة')
                                    ->url(function ($record) {
                                        // Retrieve the latitude and longitude from the address
                                        $lat = $record->address->latitude;
                                        $lng = $record->address->longitude;
            
                                        // Generate the Google Maps URL using the latitude and longitude
                                        $url = "https://www.google.com/maps?q={$lat},{$lng}";
            
                                        // Open the Google Maps link in a new tab
                                        return $url;
                                    })
                                    ->openUrlInNewTab()
                                    ->color('success')
                                    ->icon('heroicon-o-map')
                                    ->outlined()
                            ])->columnSpan(1),
                        ]),
                ])
                ->columns(1)
                ->collapsible(),
            // Products Section
            Components\Section::make('المنتجات')
                ->schema([
                    Components\RepeatableEntry::make('products')
                        ->schema([
                            Components\Grid::make(4)
                                ->schema([
                                    Components\TextEntry::make('name')
                                        ->label('اسم المنتج')
                                        ->columnSpan(2),

                                    Components\TextEntry::make('pivot.quantity')
                                        ->label('الكمية')
                                        ->columnSpan(1),

                                    Components\TextEntry::make('price')
                                        ->label('السعر')
                                        ->columnSpan(1),

                                    Components\TextEntry::make('sub_total')
                                        ->label('المجموع لهذه المنتجات')
                                        ->columnSpan(1)
                                        ->formatStateUsing(function ($state, $record) {
                                            // Ensure 'pivot' contains quantity and 'price' exists on the product
                                            if (isset($record->pivot->quantity) && isset($record->price)) {
                                                return $record->price * $record->pivot->quantity;
                                            }
                                            return 0; // Return 0 if any required data is missing
                                        }),

                                    Components\Actions::make([
                                        Components\Actions\Action::make('viewProduct')
                                            ->label('عرض المنتج')
                                            ->action(function ($record) {
                                                return redirect()->to(url('admin/products', ['id' => $record->id]));
                                            })
                                            ->color('primary')
                                            ->icon('heroicon-o-eye')
                                            ->outlined()
                                            
                                    ])->columnSpan(1),
                                ]),
                        ])
                        ->hiddenLabel()
                        ->columns(1) // Display products in a single column layout
                        ->columnSpan('full'), // Full-width for better visibility
                ])
                ->collapsible(),


        
        ]);
}


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            // 'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }


    public static function canCreate(): bool
    {
        return false;
    }
}
