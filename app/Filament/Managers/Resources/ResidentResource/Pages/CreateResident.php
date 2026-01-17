<?php
// app/Filament/Managers/Resources/ResidentResource/Pages/CreateResident.php

namespace App\Filament\Managers\Resources\ResidentResource\Pages;

use App\Filament\Managers\Resources\ResidentResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateResident extends CreateRecord
{
    protected static string $resource = ResidentResource::class;

    protected function beforeCreate(): void
    {
        $admin = auth()->user();

        if (!$admin->canAddResident()) {
            Notification::make()
                ->title('لقد وصلت للحد الأقصى')
                ->body('لا يمكنك إضافة المزيد من المقيمين في خطتك الحالية')
                ->danger()
                ->send();

            $this->halt();
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'تم إضافة المقيم بنجاح';
    }
}
