<?php

namespace App\Filament\Resources\DailyWorkLogs\Schemas;

use App\Models\DailyWorkLog;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class DailyWorkLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               Section::make(__('admin.work_log_information'))
                    ->schema([
                        TextEntry::make('task.title')
                            ->label(__('admin.task'))
                            ->placeholder('-'),

                        TextEntry::make('work_description')
                            ->label(__('admin.work_description'))
                            ->placeholder('-')
                            ->html(),

                    ]),

                Section::make(__('admin.employee_info'))
                    ->schema([
                        TextEntry::make('user.name')
                            ->label(__('admin.employee'))
                            ->placeholder('-'),


                        TextEntry::make('work_date')
                            ->label(__('admin.work_date'))
                            ->date()
                            ->placeholder('-'),    
                    ]),

                Section::make(__('admin.timestamps'))
                    ->schema([
                        TextEntry::make('created_at')
                            ->label(__('admin.created_at'))
                            ->dateTime()
                            ->placeholder('-'),

                        TextEntry::make('updated_at')
                            ->label(__('admin.updated_at'))
                            ->dateTime()
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
