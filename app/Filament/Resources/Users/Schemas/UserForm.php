<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DateTimePicker;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               Section::make(__('admin.basic_information'))
                ->schema([
                    TextInput::make('name')
                        ->label(__('admin.name'))
                        ->required()
                        ->maxLength(255),

                    Select::make('roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->label(__('admin.assign_roles')),    

                    TextInput::make('email')
                        ->label(__('admin.email'))
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),


                    TextInput::make('password')
                        ->label(__('admin.password'))
                        ->password()
                        ->minLength(8)
                        ->revealable()
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->dehydrated(fn ($state) => filled($state))
                        ->required(fn (string $context): bool => $context === 'create'),
                ])
                ->columns(1),

            Section::make(__('admin.developer_information'))
                ->description(__('admin.optional_description'))
                ->schema([
                    TextInput::make('github_account')
                        ->label(__('admin.github_account'))
                        ->placeholder('https://github.com/username')
                        ->maxLength(255),

                    TextInput::make('working_hours')
                        ->label(__('admin.working_hours'))
                        ->placeholder(__('admin.working_hours_placeholder'))
                        ->maxLength(255),
                ])
                ->collapsible(),
            ]);
    }
}
