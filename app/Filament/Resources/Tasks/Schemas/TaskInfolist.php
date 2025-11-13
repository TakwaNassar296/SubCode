<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Models\Task;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class TaskInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.task_information'))
                    ->schema([
                        TextEntry::make('title')
                            ->label(__('admin.title')),

                        TextEntry::make('description')
                            ->label(__('admin.description'))
                            ->placeholder('-')
                            ->html(),
                    ]),

                Section::make(__('admin.status_and_due'))
                    ->schema([
                        TextEntry::make('status')
                            ->label(__('admin.status')),

                        TextEntry::make('due_date')
                            ->label(__('admin.due_date'))
                            ->date()
                            ->placeholder('-'),
                    ]),

                Section::make(__('admin.project_assignment'))
                    ->schema([
                        TextEntry::make('project.name')
                            ->label(__('admin.project'))
                            ->placeholder('-'),

                        TextEntry::make('user.name')
                            ->label(__('admin.employee'))
                            ->placeholder('-'),

                        TextEntry::make('link')
                            ->label('Task Link'),
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
