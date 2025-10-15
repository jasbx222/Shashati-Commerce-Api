<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ChildrenRelationManager extends RelationManager
{
    protected static string $relationship = 'children';

    protected static ?string $title = 'الفئات الفرعية';


    public static function getModelLabel(): string
    {
        return 'الفئة الفرعية';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label('الاسم')
                                    ->required()
                                    ->maxLength('25')
                                    ->columnSpanFull(),
                            ])->columnSpan(1),
                        section::make()
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
                            ])->columnSpan(1)
                    ])->columns(2)->columnSpanFull(2)
                    ->columns(2)

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('الفئة الفرعية')
            ->pluralModelLabel('الفئات الفرعية')
            ->modelLabel('الفئة الفرعية')
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('image')
                    ->label('الايقونة')
                    ->circular(),
                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),
                TextColumn::make('products_count')
                    ->label('عدد المنتجات'),
                TextColumn::make('created_at')
                    ->label('تاريخ الأنشاء')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
