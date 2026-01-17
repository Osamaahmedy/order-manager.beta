<?php

namespace App\Filament\Managers\Resources\OrderResource\Pages;

use App\Filament\Managers\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
