<?php
// app/Filament/Managers/Resources/BranchResource/Pages/EditBranch.php

namespace App\Filament\Managers\Resources\BranchResource\Pages;

use App\Filament\Managers\Resources\BranchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBranch extends EditRecord
{
    protected static string $resource = BranchResource::class;

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
        return 'تم تحديث الفرع بنجاح';
    }
}
