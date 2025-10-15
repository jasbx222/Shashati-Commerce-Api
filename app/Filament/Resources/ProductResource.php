<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $pluralModelLabel = 'المنتجات';

    protected static ?string $modelLabel = 'المنتج';

    protected static ?string $navigationGroup = 'المنتجات';

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('البيانات الاساسية')
                            ->schema([
                                Group::make()
                                    ->schema([
                                        Section::make()
                                            ->schema([
                                                TextInput::make('name')
                                                    ->label('اسم المنتج')
                                                    ->required()
                                                    ->minLength(2)
                                                    ->maxLength(255)
                                                    ->placeholder('أدخل اسم المنتج'),
                                                Textarea::make('description')
                                                    ->label('الوصف')
                                                    ->rows('7')
                                                    ->required()
                                                    ->placeholder('أدخل وصف للمنتج'),
                                            ])->columnSpan('1'),
                                        Section::make()
                                            ->schema([
                                                Select::make('category_id')
                                                    ->label('الفئة')
                                                    ->required()

                                                    ->relationship('category', 'name', fn($query) => $query->subcategories()),

                                                Select::make('is_offer')
                                                    ->label('عليه عرض؟')
                                                    ->options([
                                                        1 => 'نعم',
                                                        0 => 'لا',
                                                    ])
                                                    ->required()
                                                    ->native(false),



                                                TextInput::make('offer_name')
                                                    ->label('اسم العرض')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->placeholder('أدخل اسم العرض للمنتج'),

                                                TextInput::make('quantity')
                                                    ->label('الكمية')
                                                    ->required()
                                                    ->numeric()
                                                    ->minValue(0) // Ensures the value must be at least 0 (non-negative)
                                                    ->placeholder('أدخل كمية المنتج'), // Optional placeholder
                                                TextInput::make('price')
                                                    ->label('السعر')
                                                    ->required()
                                                    ->numeric()
                                                    ->minValue(0),
                                                TextInput::make('price_after')
                                                    ->label('السعر بعد الخصم')
                                                    ->numeric()
                                                    ->minValue(0),
                                            ])->columnSpan('1')

                                    ])->columns('2')->columnSpan('2'),
                            ])->columnSpanFull(),

                        Tabs\Tab::make('الصور')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('الصور')
                                    ->disk('public')
                                    ->multiple()
                                    ->directory('images/product')
                                    ->image()
                                    ->required()
                                    ->getUploadedFileNameForStorageUsing(
                                        fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                            ->prepend('product-image-'),
                                    )
                                    ->reorderable()
                                    ->openable()
                            ])
                            ->columnSpanFull()
                            ->columns('2')


                    ])->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('الفئة'),
                TextColumn::make('price')
                    ->label('السعر')
                    ->sortable(),
                TextColumn::make('price_after')
                    ->label('السعر بعد الخصم')
                    ->sortable(),
                TextColumn::make('quantity')
                    ->label('الكمية')
                    ->sortable(),
                IconColumn::make('is_offer')
                    ->label('عرض؟')
            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('category', 'name', fn($query) => $query->subcategories()),
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
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
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
                fn(Action $action) => $action
                    ->button()
                    ->slideOver()
                    ->label('تصفية'),
            )
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('toggleOffer')
                        ->label('اضافة او الغاء المنتج من العرض')
                        ->action(function ($record) {
                            // Toggle the value of `is_offer`
                            $record->update([
                                'is_offer' => !$record->is_offer,
                            ]);
                        })
                        ->icon('heroicon-o-briefcase') // Optional: Icon for the action
                        ->color(fn($record) => $record->is_offer ? 'success' : 'secondary') // Optional: Color indicator based on state
                        ->tooltip(fn($record) => $record->is_offer ? 'الغاء العرض' : 'تفعيل العرض'), // Tooltip for clarity
                ])
                    ->iconButton()
                    ->tooltip('العمليات')
                    ->size(ActionSize::Medium),
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
                                            ->label('الاسم')
                                            ->color('primary'),
                                        Components\TextEntry::make('category.name')
                                            ->label('الفئة')
                                            ->color('primary'),
                                        Components\TextEntry::make('quantity')
                                            ->label('الكمية')
                                            ->color('primary'),
                                    ]),
                                    Components\Group::make([
                                        Components\TextEntry::make('price')
                                            ->label('السعر')
                                            ->color('primary'),
                                        Components\TextEntry::make('price_after')
                                            ->label('السعر بعد الخصم')
                                            ->color('primary'),

                                    ]),
                                    Components\Group::make([
                                        ImageEntry::make('image')
                                            ->hiddenLabel()
                                            ->circular()
                                    ])
                                ])
                        ])->from('lg'),
                        Components\Section::make('وصف المنتج')
                            ->schema([
                                Components\TextEntry::make('description')
                                    ->prose()
                                    ->markdown()
                                    ->hiddenLabel(),
                            ])
                            ->collapsible(),
                    ])
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
            'view' => pages\ViewProduct::route('/{record}')
        ];
    }
}
