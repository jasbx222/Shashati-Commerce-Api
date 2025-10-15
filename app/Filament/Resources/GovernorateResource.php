<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GovernorateResource\Pages;
use App\Filament\Resources\GovernorateResource\RelationManagers;
use App\Models\Governorate;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

use function Filament\Support\format_money;

class GovernorateResource extends Resource
{
    protected static ?string $model = Governorate::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup =  'الاعدادات';

    protected static ?string $pluralModelLabel = 'المحافظات';

    protected static ?string $modelLabel = 'محافظة';

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->defaultPaginationPageOption(25)
            ->columns([
                Stack::make([
                    TextColumn::make('name')
                        ->label('الاسم')
                        ->searchable(),
                    TextColumn::make('delivery_price')
                        ->label('سعر التوصيل')
                        ->prefix('IQD')
                        ->sortable()
                    ]),
                ])
                ->contentGrid([
                    'md' => 2,
                    'xl' => 4,
                ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->form([
                    TextInput::make('delivery_price')
                        ->label('سعر التوصيل')
                        ->numeric(),
                ])
                ->modalHeading('تعديل سعر التوصيل ')
                ->modalAlignment(Alignment::Center)
                ->modalWidth(MaxWidth::Small)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListGovernorates::route('/'),
            'create' => Pages\CreateGovernorate::route('/create'),
            // 'edit' => Pages\EditGovernorate::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
       return false;
    }
}
