<?php

namespace App\Filament\Resources\SlotWaktuResource\Pages;

use App\Filament\Resources\SlotWaktuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSlotWaktu extends EditRecord
{
    protected static string $resource = SlotWaktuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
