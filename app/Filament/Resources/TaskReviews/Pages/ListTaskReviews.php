<?php

namespace App\Filament\Resources\TaskReviews\Pages;

use App\Filament\Resources\TaskReviews\TaskReviewResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTaskReviews extends ListRecords
{
    protected static string $resource = TaskReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
