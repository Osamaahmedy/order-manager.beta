<?php

namespace App\Filament\Resources\DeliveryAppResource\Pages;

use App\Filament\Resources\DeliveryAppResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeliveryApp extends EditRecord
{
    protected static string $resource = DeliveryAppResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
