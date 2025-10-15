<?php

namespace App\Filament\Resources\TermsAndConditionResource\Pages;

use App\Filament\Resources\TermsAndConditionResource;
use App\Models\TermsAndCondition;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTermsAndConditions extends ListRecords
{
    protected static string $resource = TermsAndConditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('اضافة')
                ->hidden(fn () => TermsAndCondition::exists()),
        ];
    }
}
