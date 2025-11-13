<?php

namespace App\Filament\Resources\ActivityLogs\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class ActivityLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 Section::make(__('admin.activity_log.sections.event_details'))
                    ->schema([
                        TextEntry::make('description')
                            ->label(__('admin.activity_log.event'))
                            ->formatStateUsing(fn ($state, $record) => __('admin.activity_log.events.' . $record->event)),
                        TextEntry::make('subject_type')
                            ->label(__('admin.activity_log.type'))
                            ->formatStateUsing(fn ($state) => match ($state) {
                                'App\Models\User' => __('admin.activity_log.types.user'),
                                'App\Models\Task' => __('admin.activity_log.types.task'),
                                'App\Models\Project' => __('admin.activity_log.types.project'),
                                'App\Models\Problem' => __('admin.activity_log.types.problem'),
                                'App\Models\DailyWorkLog' => __('admin.activity_log.types.work_log'),
                                'App\Models\TaskReview' => __('admin.activity_log.types.task_review'),
                                default => $state,
                            }),
                        TextEntry::make('causer.name')
                            ->label(__('admin.activity_log.user')),
                        TextEntry::make('created_at')
                            ->label(__('admin.activity_log.date'))
                            ->dateTime(),
                    ])
                    ->columnSpanFull()
                    ->columns(2),
            ]);
    }
}