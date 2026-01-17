<?php
// app/Filament/Managers/Resources/ResidentResource/Pages/ListResidents.php

namespace App\Filament\Managers\Resources\ResidentResource\Pages;

use App\Filament\Managers\Resources\ResidentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListResidents extends ListRecords
{
    protected static string $resource = ResidentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('مقيم جديد')
                ->icon('heroicon-o-plus'),
        ];
    }
}
