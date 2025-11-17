<?php

namespace App\Filament\Resources\Users\Tables;

use Carbon\Carbon;
use App\Models\Task;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Illuminate\Support\Facades\DB;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;


class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
               TextColumn::make('name')
                ->label(__('admin.name'))
                ->searchable(),

               TextColumn::make('email')
                ->label(__('admin.email'))
                ->searchable(),

            TextColumn::make('roles.name')
                ->label(__('admin.roles'))
                ->sortable()
                ->wrap()
                ->separator(', ')
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('github_account')
                ->label(__('admin.github_account'))
                ->limit(20)
                ->toggleable(),

            TextColumn::make('working_hours')
                ->label(__('admin.working_hours'))
                ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
               Action::make('delete_tasks_by_period')
                ->label(__('admin.delete_tasks_by_period'))
                ->icon('heroicon-o-trash')
                ->requiresConfirmation()
                ->modalHeading(__('admin.delete_tasks_by_period'))
                ->modalSubheading(__('admin.delete_tasks_for_period'))
                ->form([
                    Select::make('period')
                        ->label(__('admin.select_period'))
                        ->options([
                            'day' => __('admin.day'),
                            'week' => __('admin.week'),
                            'month' => __('admin.month'),
                        ])
                        ->required(),

                    DatePicker::make('date')
                        ->label(__('admin.select_date'))
                        ->required()
                        ->visible(fn ($get) => $get('period') !== 'all')
                        ->default(now()),
                ])
                ->action(function ($record, array $data) {
                    $userId = $record->id;
                    $period = $data['period'];
                    $date = Carbon::parse($data['date']);

                    $query = Task::where('user_id', $userId);

                    switch ($period) {
                        case 'day':
                            $query->whereDate('created_at', $date->toDateString());
                            break;
                        case 'week':
                            $query->whereBetween('created_at', [
                                $date->copy()->startOfWeek()->toDateString(),
                                $date->copy()->endOfWeek()->toDateString(),
                            ]);
                            break;
                        case 'month':
                            $query->whereBetween('created_at', [
                                $date->copy()->startOfMonth()->toDateString(),
                                $date->copy()->endOfMonth()->toDateString(),
                            ]);
                            break;
                    }

                    $deletedCount = $query->count();

                    DB::transaction(function () use ($query) {
                        $query->delete();
                    });

                    Notification::make()
                        ->title(__('admin.tasks_deleted_successfully'))
                        ->body(__('admin.deleted_tasks_count', ['count' => $deletedCount]))
                        ->success()
                        ->send();
                })->visible(fn () => auth()->user()->hasRole('super_admin')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
