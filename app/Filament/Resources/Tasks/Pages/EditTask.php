<?php

namespace App\Filament\Resources\Tasks\Pages;

use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Tasks\TaskResource;

class EditTask extends EditRecord
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            Action::make('delete_task')
                    ->label(__('admin.delete_task'))
                    ->requiresConfirmation()
                    ->modalHeading(__('admin.delete_task'))
                    ->modalDescription(__('admin.delete_if_completed'))
                    ->action(function ($record, Action $action) {
                        if ($record->status !== 'completed') {
                            $action->failureNotificationTitle(__('admin.cannot_delete_task'));
                            return;
                        }

                        $record->delete();
                        $action->successNotificationTitle(__('admin.task_deleted'));
                    }),
        ];
    }
}
