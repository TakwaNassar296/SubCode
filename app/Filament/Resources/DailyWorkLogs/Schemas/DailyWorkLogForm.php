<?php

namespace App\Filament\Resources\DailyWorkLogs\Schemas;

use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;

class DailyWorkLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.work_log_information'))
                    ->schema([
                        Select::make('task_id')
                            ->label(__('admin.task'))
                            ->relationship('task', 'title')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Textarea::make('work_description')
                            ->label(__('admin.work_description'))
                            ->required()
                            ->rows(3)
                            ->maxLength(1000),

                        DatePicker::make('work_date')
                            ->label(__('admin.work_date'))
                            ->default(now())
                            ->required(),

                        Hidden::make('user_id')
                            ->default(Auth::id()),
                    ])
                    ->columns(1)
                    ->columnSpanFull(),
            ]);
    }
}
