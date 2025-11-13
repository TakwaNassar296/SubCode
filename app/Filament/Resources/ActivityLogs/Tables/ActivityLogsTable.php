<?php

namespace App\Filament\Resources\ActivityLogs\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class ActivityLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description')
                    ->label(__('admin.activity_log.event'))
                    ->sortable()
                    ->formatStateUsing(fn ($state, $record) => __('admin.activity_log.events.' . $record->event)),

                TextColumn::make('subject_type')
                    ->label(__('admin.activity_log.type'))
                    ->formatStateUsing(fn ($state) => match ($state) {
                            'App\Models\User' => __('admin.activity_log.types.user'),
                            'App\Models\Task' => __('admin.activity_log.types.task'),
                            'App\Models\Project' => __('admin.activity_log.types.project'),
                            'App\Models\Problem' => __('admin.activity_log.types.problem'),
                            'App\Models\DailyWorkLog' => __('admin.activity_log.types.work_log'),
                            'App\Models\TaskReview' => __('admin.activity_log.types.task_review'),
                            default => $state,
                        })
                    ->sortable(),

                TextColumn::make('causer.name')
                    ->label(__('admin.activity_log.user'))
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('admin.activity_log.date'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('subject_type')
                    ->label(__('admin.activity_log.filters.item_type'))
                    ->options([
                        'App\Models\User' => __('admin.activity_log.types.user'),
                        'App\Models\Task' => __('admin.activity_log.types.task'),
                        'App\Models\Project' => __('admin.activity_log.types.project'),
                        'App\Models\Problem' => __('admin.activity_log.types.problem'),
                        'App\Models\DailyWorkLog' => __('admin.activity_log.types.work_log'),
                        'App\Models\TaskReview' => __('admin.activity_log.types.task_review'),
                    ]),

                SelectFilter::make('event')
                    ->label(__('admin.activity_log.filters.event_type'))
                    ->options([
                        'created' => __('admin.activity_log.events.created'),
                        'updated' => __('admin.activity_log.events.updated'),
                        'deleted' => __('admin.activity_log.events.deleted'),
                    ]),

                 ...self::getTableFilters(),       
            ])
            ->recordActions([
                ViewAction::make(),
               // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }


     public static function getTableFilters(): array
    {
        return [
            SelectFilter::make('date_period')
                ->label(__('admin.filter_by_period'))
                ->options([
                    'today' => __('admin.today'),
                    'last_7_days' => __('admin.last_7_days'),
                    'this_month' => __('admin.this_month'),
                    'last_month' => __('admin.last_month'),
                    'this_year' => __('admin.this_year'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    $period = $data['value'];

                    $column = 'created_at'; 

                    return match ($period) {
                        'today' => $query->whereDate($column, Carbon::today()),
                        'last_7_days' => $query->whereBetween($column, [
                            Carbon::now()->subDays(6)->startOfDay(), 
                            Carbon::now()->endOfDay()
                        ]),
                        'this_month' => $query->whereMonth($column, Carbon::now()->month)
                            ->whereYear($column, Carbon::now()->year),
                        'last_month' => $query->whereMonth($column, Carbon::now()->subMonth()->month)
                            ->whereYear($column, Carbon::now()->subMonth()->year),
                        'this_year' => $query->whereYear($column, Carbon::now()->year),
                        default => $query,
                    };
                }),
        ];
    }
}