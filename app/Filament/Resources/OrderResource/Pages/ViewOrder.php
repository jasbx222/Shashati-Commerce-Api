<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\Support\Htmlable;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;


    public function getTitle(): string | Htmlable
    {
        /** @var Post */
        $record = $this->getRecord();

        return $record->id;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
            ->form([
                Select::make('status') // Create a dropdown to select the status
                    ->label('حالة الطلب') // Set the label for the status field
                    ->options([
                        'pending' => 'معلق',
                        'accepted' => 'مقبول',
                        'returned' => 'مسترجع',
                        'completed' => 'مكتمل',
                        'cancelled' => 'ملغى',
                    ])
                    ->required(), // Make sure to require the status field
            ])
            ->modalHeading('تعديل حالة الطلب') // Heading of the modal
            ->modalAlignment(Alignment::Center) // Align the modal to the center
            ->modalWidth(MaxWidth::Large) // Set the width of the modal
            ->after(function ($record, array $data) {
                // After saving the new status, you can execute any additional actions if needed
                $record->update([
                    'status' => $data['status'],
                ]);
            })
            ->action(function ($record) {
                // You can optionally show some data or perform other actions before the modal is shown
                return $record;
            })
            ->button('تعديل حالة الطلب'), // Label for the button
        ];
    }
}
