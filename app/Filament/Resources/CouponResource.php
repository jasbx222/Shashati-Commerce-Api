<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Filament\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-command-line';

    protected static ?string $pluralModelLabel = 'الكوبونات';

    protected static ?string $modelLabel = 'كوبون';

    protected static ?string $navigationGroup = 'المنتجات';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                ->required()
                ->minLength(8)
                ->maxLength(8)
                ->unique(ignoreRecord: true)
                ->label('كود الكوبون')
                ->suffixAction(
                    fn () => \Filament\Forms\Components\Actions\Action::make('generate')
                        ->label('توليد')
                        ->icon('heroicon-o-command-line') // توفير اسم أيقونة هنا
                        ->action(function (callable $set) {
                            $set('code', strtoupper(bin2hex(random_bytes(4)))); // توليد وتعيين الكود
                        })
                ),
                
                Select::make('type')
                    ->options([
                        'percentage' => 'نسبة مئوية',
                        'fixed' => 'قيمة ثابتة',
                    ])
                    ->required()
                    ->label('نوع الخصم'),
                
                TextInput::make('value')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->label('قيمة الخصم'),
                
                TextInput::make('minimum_order_amount')
                    ->numeric()
                    ->minValue(1)
                    ->label('الحد الأدني لمرات الاستخدام'),
                
                DatePicker::make('expires_at')
                    ->label('تاريخ الانتهاء'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('كود الكوبون')
                    ->searchable(), // Makes the column searchable
                
                TextColumn::make('type')
                    ->label('نوع الخصم')
                    ->formatStateUsing(fn ($state) => $state === 'percentage' ? 'نسبة مئوية' : 'قيمة ثابتة'),
                
                TextColumn::make('value')
                    ->label('قيمة الخصم')
                    ->sortable(),
                
                TextColumn::make('minimum_order_amount')
                    ->label('الحد الأدنى للاستخدام')
                    ->sortable(),
                
                TextColumn::make('expires_at')
                    ->date('Y-m-d')
                    ->label('تاريخ الانتهاء')
                    ->sortable(), // Allows sorting by date
                
                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->date('Y-m-d'), // Formats as a readable date
            ])
            ->filters([
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
            ])
            ->actions([
                Tables\Actions\ViewAction::make(), // Action to view the record
                Tables\Actions\EditAction::make(), // Action to edit the record
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(), // Bulk delete action
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'view' => Pages\ViewCoupon::route('/{record}'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }

    public static function generateCode(): string
    {
        return strtoupper(bin2hex(random_bytes(4))); // مثال على كود عشوائي
    }

}
