<?php

namespace App\Filament\Resources\DailyWorkLogs\Pages;

use App\Filament\Resources\DailyWorkLogs\DailyWorkLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDailyWorkLogs extends ListRecords
{
    protected static string $resource = DailyWorkLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
