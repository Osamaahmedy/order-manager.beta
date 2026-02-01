<?php

namespace App\Filament\Resources\SubscriptionRenewalRequestResource\Pages;

use App\Filament\Resources\SubscriptionRenewalRequestResource;
use Filament\Resources\Pages\EditRecord;

class EditSubscriptionRenewalRequest extends EditRecord
{
    protected static string $resource = SubscriptionRenewalRequestResource::class;

    protected function beforeSave(): void
    {
        if ($this->record->isDirty('status') && $this->record->status !== 'pending') {
            $this->record->reviewed_at = now();
            $this->record->reviewed_by = optional(auth())->id();
        }
    }
}
