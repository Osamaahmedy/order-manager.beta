<?php
// app/Filament/Managers/Resources/BranchResource/Pages/CreateBranch.php

namespace App\Filament\Managers\Resources\BranchResource\Pages;

use App\Filament\Managers\Resources\BranchResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateBranch extends CreateRecord
{
    protected static string $resource = BranchResource::class;

    protected function beforeCreate(): void
    {
        $admin = auth()->user();

        if (!$admin->canAddBranch()) {
            Notification::make()
                ->title('لقد وصلت للحد الأقصى')
                ->body('لا يمكنك إضافة المزيد من الفروع في خطتك الحالية')
                ->danger()
                ->send();

            $this->halt();
        }
    }

    protected function afterCreate(): void
    {
        // ربط الفرع بالـ Admin
        $this->record->admins()->attach(auth()->id());
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'تم إضافة الفرع بنجاح';
    }
}
