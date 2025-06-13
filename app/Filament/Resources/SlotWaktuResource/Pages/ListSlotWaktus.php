<?php

namespace App\Filament\Resources\SlotWaktuResource\Pages;

use App\Filament\Resources\SlotWaktuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSlotWaktus extends ListRecords
{
    protected static string $resource = SlotWaktuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
