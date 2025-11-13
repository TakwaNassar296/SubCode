<?php

namespace App\Filament\Resources\DailyWorkLogs\Pages;

use App\Filament\Resources\DailyWorkLogs\DailyWorkLogResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDailyWorkLog extends ViewRecord
{
    protected static string $resource = DailyWorkLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
