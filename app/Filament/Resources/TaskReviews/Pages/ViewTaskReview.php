<?php

namespace App\Filament\Resources\TaskReviews\Pages;

use App\Filament\Resources\TaskReviews\TaskReviewResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTaskReview extends ViewRecord
{
    protected static string $resource = TaskReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
