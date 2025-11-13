<?php

namespace App\Filament\Resources\DailyWorkLogs\Pages;

use App\Filament\Resources\DailyWorkLogs\DailyWorkLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDailyWorkLog extends CreateRecord
{
    protected static string $resource = DailyWorkLogResource::class;
}
