<?php

namespace App\Filament\Resources\Tasks\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
               TextColumn::make('title')
                ->label(__('admin.title'))
                ->searchable()
                ->limit(50),


                TextColumn::make('description')
                ->label(__('admin.description'))
                ->searchable()
                ->limit(50)
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('project.name')
                ->label(__('admin.project'))
                ->sortable(),

            TextColumn::make('status')
                ->label(__('admin.status'))
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'pending' => 'gray',
                    'in_progress' => 'warning',
                    'completed' => 'success',
                    'needs_review' => 'danger',
                }),

            TextColumn::make('user.name')
                ->label(__('admin.employee'))
                ->sortable(),

            TextColumn::make('due_date')
                ->label(__('admin.due_date'))
                ->date()
                ->sortable()
                ->toggleable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                 SelectFilter::make('status')
                ->label(__('admin.status'))
                ->options([
                    'pending' => __('admin.pending'),
                    'in_progress' => __('admin.in_progress'),
                    'completed' => __('admin.completed'),
                    'needs_review' => __('admin.needs_review'),
                ]),

            SelectFilter::make('project_id')
                ->label(__('admin.project'))
                ->relationship('project', 'name'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
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
              
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                   DeleteBulkAction::make()
                    ->action(function (Collection $records, DeleteBulkAction $action) {
                        $recordsToDelete = $records->where('status', 'completed');
                        $notDeletedCount = $records->where('status', '!=', 'completed')->count();

                        if ($notDeletedCount > 0) {
                            $action->failureNotificationTitle(__('admin.cannot_delete_task'));
                        }

                        if ($recordsToDelete->isNotEmpty()) {
                            $recordsToDelete->each->delete();
                            $deletedCount = $recordsToDelete->count();
                            $action->successNotificationTitle(
                                trans_choice('admin.tasks_deleted', $deletedCount, ['count' => $deletedCount])
                            );
                        }
                    })
                    ->requiresConfirmation()
                    ->modalHeading(__('admin.delete_completed_tasks'))
                    ->modalDescription(__('admin.only_completed_tasks_deleted')),
                    ExportAction::make(),
                ]),
            ])->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();
                if ($user->hasRole('super_admin') || $user->hasRole('manager')) {
                    return $query; 
                }
                return $query->where('user_id', $user->id);
            });
    }
}
