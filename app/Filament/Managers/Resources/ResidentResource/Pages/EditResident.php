<?php
// app/Filament/Managers/Resources/ResidentResource/Pages/EditResident.php

namespace App\Filament\Managers\Resources\ResidentResource\Pages;

use App\Filament\Managers\Resources\ResidentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResident extends EditRecord
{
    protected static string $resource = ResidentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'تم تحديث المقيم بنجاح';
    }
}
