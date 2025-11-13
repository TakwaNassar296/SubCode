<?php

namespace App\Filament\Resources\DailyWorkLogs\Pages;

use App\Filament\Resources\DailyWorkLogs\DailyWorkLogResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDailyWorkLog extends EditRecord
{
    protected static string $resource = DailyWorkLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
