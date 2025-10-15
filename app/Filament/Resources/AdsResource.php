<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdsResource\Pages;
use App\Filament\Resources\AdsResource\RelationManagers;
use App\Models\Ads;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class AdsResource extends Resource
{
    protected static ?string $model = Ads::class;

    protected static ?int $navigationSort = 7;

    
    protected static ?string $navigationGroup = 'الاعلانات';

    protected static ?string $pluralModelLabel = 'الاعلانات';

    protected static ?string $modelLabel = 'إعلان';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                ->schema([
                    Section::make()
                        ->schema([
                            TextInput::make('title')
                                ->label('العنوان')
                                ->required()
                                ->minLength(2)
                                ->maxLength(255)
                                ->placeholder('أدخل عنوان'),
                            Select::make('type')
                                ->required()
                                ->label('النوع')
                                ->options([
                                    'slider' => 'سلايدر',
                                    'banner' => 'بانر',
                                    'middle' => 'منتصف الصفحة',
                                    'last' => 'آخر الصفحة',
                                ]),
                            Select::make('produt_id')
                                    ->label('يمكنك تخصيص الاعلان للمنتج...')
                                    ->relationship('product', 'name'),
                        ])->columns('1')->columnSpan(1),
                    Section::make()
                            ->schema([
                                FileUpload::make('image')
                                    ->label('الصورة')
                                    ->required()
                                    ->directory('images/ads')
                                    ->image()
                                    ->getUploadedFileNameForStorageUsing(
                                        fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                            ->prepend('ads-image-'),
                                    )
                                    ->openable()
                            ])->columnSpan(1)
                ])->columns(2)->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('صورة')
                    ->circular(),
                TextColumn::make('title')
                    ->label('العنوان'),
                TextColumn::make('type')
                    ->label('النوع')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => __("{$state}")),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('النوع')
                    ->options([
                        'slider' => 'سلايدر',
                        'banner' => 'بانر',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make(),
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
            'index' => Pages\ListAds::route('/'),
            'create' => Pages\CreateAds::route('/create'),
            'edit' => Pages\EditAds::route('/{record}/edit'),
        ];
    }
}
