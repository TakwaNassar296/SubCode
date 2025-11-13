<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class ProjectInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.project_information'))
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('admin.project_name')),

                        TextEntry::make('deadline')
                            ->label(__('admin.deadline'))
                            ->date(),

                        TextEntry::make('created_at')
                            ->label(__('admin.created_at'))
                            ->dateTime(),
                    ]),

                Section::make(__('admin.team_members'))
                    ->schema([
                        TextEntry::make('users_list')
                            ->label(__('admin.team_members'))
                            ->getStateUsing(fn ($record) => 
                                $record->users->pluck('name')->implode(', ')
                            )
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
