<?php
// app/Filament/Managers/Resources/BranchResource/Pages/ListBranches.php

namespace App\Filament\Managers\Resources\BranchResource\Pages;

use App\Filament\Managers\Resources\BranchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBranches extends ListRecords
{
    protected static string $resource = BranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('فرع جديد')
                ->icon('heroicon-o-plus'),
        ];
    }
}
