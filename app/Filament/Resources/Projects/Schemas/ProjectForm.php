<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.project_information'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('admin.project_name'))
                            ->required()
                            ->maxLength(255),

                        DatePicker::make('deadline')
                            ->label(__('admin.deadline')),
                    ])
                    ->columns(2),

                Section::make(__('admin.team_members'))
                    ->schema([
                        Select::make('users')
                            ->label(__('admin.team_members'))
                            ->multiple()
                            ->relationship('users', 'name')
                            ->searchable()
                            ->preload(),
                    ]),
            ]);
    }
}
