<?php

namespace App\Filament\Resources\Problems\Pages;

use App\Filament\Resources\Problems\ProblemResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProblem extends ViewRecord
{
    protected static string $resource = ProblemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
