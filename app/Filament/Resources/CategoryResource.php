<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Filament\Resources\CategoryResource\RelationManagers\ChildrenRelationManager;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\Layout\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $pluralModelLabel = 'الفئات';

    protected static ?string $modelLabel = 'فئة اساسية';
    
  protected static ?string $navigationGroup = 'المنتجات';

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                Fieldset::make()
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('الاسم')
                                            ->required()
                                            ->maxLength('25')
                                            ->columnSpanFull(),
                                    ]),
                            ])->columnSpan(1),
                        section::make()
                            ->schema([
                                Fieldset::make()
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label('الايقونة')
                                            ->disk('public')
                                            ->directory('images/category')
                                            ->image()
                                            ->required()
                                            ->getUploadedFileNameForStorageUsing(
                                                fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                                    ->prepend('category-image-'),
                                            )
                                            ->reorderable()
                                            ->openable()
                                            ->columnSpanFull(),
                                    ])
                            ])->columnSpan(1)
                    ])->columns(2)->columnSpanFull(2)
                    ->columns(2)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(25)
            ->columns([
                Split::make([
                    Stack::make([
                        ImageColumn::make('image')
                            ->label('الايقونة')
                            ->circular()
                            ->columnSpanFull(),
                    ])->space(),
                    Stack::make([
                        TextColumn::make('name')
                        ->label('الاسم')
                        ->searchable(),
                    TextColumn::make('sub_category_count')
                        ->label('عدد الفئات الفرعية')
                        ->searchable(),
                    ])->space(),
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
                        TextInput::make('name')
                            ->label('اسم الفئة')
                            ->maxLength('25'),
                    ])
                    ->modalHeading('تعديل اسم الفئة ')
                    ->modalAlignment(Alignment::Center)
                    ->modalWidth(MaxWidth::Small),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ChildrenRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

 
}
