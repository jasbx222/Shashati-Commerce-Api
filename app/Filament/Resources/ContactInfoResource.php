<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactInfoResource\Pages;
use App\Filament\Resources\ContactInfoResource\RelationManagers;
use App\Models\ContactInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;
use Filament\Forms\Components\Actions as ComponentsActions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactInfoResource extends Resource
{
    protected static ?string $model = ContactInfo::class;

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup =  'الاعدادات';

    protected static ?string $pluralModelLabel = 'معلومات اتصل بنا';

    protected static ?string $modelLabel = 'معلومات اتصل بنا';

    protected static ?string $navigationIcon = 'heroicon-o-phone-arrow-down-left';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('support_message')
                ->label('رسالة الدعم')
                ->required(),
                
            Forms\Components\TextInput::make('phone')
                ->label('رقم الهاتف')
                ->required(),
                
            Forms\Components\TextInput::make('email')
                ->label('البريد الإلكتروني')
                ->email()
                ->required(),
                
            Forms\Components\TextInput::make('website')
                ->label('الموقع الإلكتروني')
                ->url()
                ->required(),
                
            Forms\Components\Textarea::make('address')
                ->label('العنوان')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('phone')
                    ->label('الهاتف'),
                Tables\Columns\TextColumn::make('email')
                    ->label('الايميل'),
            ])->paginated(false)
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListContactInfos::route('/'),
            'create' => Pages\CreateContactInfo::route('/create'),
            'edit' => Pages\EditContactInfo::route('/{record}/edit'),
        ];
    }

    protected static function configureActions(ComponentsActions $actions): array
    {
        return [
            Actions\DeleteAction::make()->hidden(),
            Actions\CreateAction::make()
                ->hidden(fn () => ContactInfo::exists()),
        ];
}
}
