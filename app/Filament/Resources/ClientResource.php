<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $pluralModelLabel = 'العملاء';

    protected static ?string $modelLabel = 'العميل';

    protected static ?string $navigationGroup = 'العملاء';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('الرقم')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('الايميل')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('مفعل')
                    ->boolean(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->label('تاريخ الميلاد')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone_verified_at')
                    ->label('تاريخ تأكيد الحساب')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_confirmed')
                    ->label('مؤكد')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الأنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
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
            Components\Section::make()
            ->schema([
                Components\Split::make([
                    Components\Grid::make(3)
                        ->schema([
                            Components\Group::make([
                                Components\TextEntry::make('name')
                                    ->label('الاسم'),
                                    
                                Components\TextEntry::make('phone')
                                    ->label('الرقم'),
                                    
                                Components\TextEntry::make('email')
                                    ->label('الايميل'),
                                    
                                Components\IconEntry::make('is_active')
                                    ->label('مفعل'),
                            ]),
                            Components\Group::make([
                                Components\TextEntry::make('birth_date')
                                    ->label('تاريخ الميلاد')
                                    ->date(),
                                    
                                Components\TextEntry::make('phone_verified_at')
                                    ->label('تاريخ تأكيد الحساب')
                                    ->date(),
                                    
                                Components\IconEntry::make('is_confirmed')
                                    ->label('مؤكد'),
                                    
                                Components\TextEntry::make('created_at')
                                    ->label('تاريخ الإنشاء')
                                    ->date(),
                                ]),
                            ]),
                    ])->from('lg'),
                ]),

                Components\Section::make('الطلبات')
                ->schema([
                    Components\RepeatableEntry::make('orders')
                        ->schema([
                            Components\Section::make('الطلب')
                                ->schema([
                                    Components\Grid::make(4)
                                        ->schema([
                                            Components\TextEntry::make('id')
                                                ->label('رقم الطلب')
                                                ->columnSpan(1),
            
                                            Components\TextEntry::make('total')
                                                ->label('الإجمالي')
                                                ->columnSpan(1),
            
                                            Components\TextEntry::make('delivery_price')
                                                ->label('سعر التوصيل')
                                                ->columnSpan(1),
            
                                            Components\TextEntry::make('total_with_delivery_price')
                                                ->label('الإجمالي مع التوصيل')
                                                ->columnSpan(1),
                                            Components\TextEntry::make('status')
                                                ->label('حالة الطلب')
                                                ->formatStateUsing(fn (string $state): string => __("{$state}"))
                                                ->columnSpan(1),
                                                Components\Actions::make([
                                                    Components\Actions\Action::make('ViewOrder')
                                                        ->label('عرض الطلب')
                                                        ->action(function ($record) {
                                                            return redirect()->to(url('admin/orders', ['id' => $record->id]));
                                                        })
                                                        ->color('primary')
                                                        ->icon('heroicon-o-eye')
                                                        ->outlined()
                                                        
                                                ])->columnSpan(1),
                                        ]),
                                ])->collapsible(),
            
                           
                        ])
                        ->columns(1) // عرض الأقسام بشكل عمودي
                        ->columnSpan('full'), // يشغل السطر بالكامل
                ])->hiddenLabel(),
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'view' => Pages\ViewClient::route('/{record}'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canUpdate(): bool
    {
        return false;
    }
}
