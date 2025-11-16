<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.basic_information'))
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('admin.name')),

                        TextEntry::make('email')
                            ->label(__('admin.email')),
                        
                        TextEntry::make('roles.name')
                            ->label(__('admin.roles'))
                            ->separator(', ')
                            ->wrap(),

                    ]),

                Section::make(__('admin.developer_information'))
                    ->description(__('admin.optional_description'))
                    ->schema([
                        TextEntry::make('github_account')
                            ->label(__('admin.github_account'))
                            ->placeholder('-'),

                        TextEntry::make('working_hours')
                            ->label(__('admin.working_hours'))
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
