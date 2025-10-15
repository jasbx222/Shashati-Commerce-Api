<?php

namespace App\Filament\Resources\ContactInfoResource\Pages;

use App\Filament\Resources\ContactInfoResource;
use App\Models\ContactInfo;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactInfos extends ListRecords
{
    protected static string $resource = ContactInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('اضافة')->hidden(fn () => ContactInfo::exists()),
        ];
    }
}
