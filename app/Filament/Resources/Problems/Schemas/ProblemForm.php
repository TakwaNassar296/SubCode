<?php

namespace App\Filament\Resources\Problems\Schemas;

use App\Models\User;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;

class ProblemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               Section::make(__('admin.problem_information'))
                ->schema([
                    TextInput::make('title')
                        ->label(__('admin.title'))
                        ->required()
                        ->maxLength(255),

                    RichEditor::make('description')
                        ->label(__('admin.description'))
                        ->required()
                        ->maxLength(1000),

                    Select::make('task_id')
                        ->label(__('admin.related_task'))
                        ->relationship('task', 'title')
                        ->required()
                        ->searchable()
                        ->preload(),
                ])
                ->columns(1),

            Section::make(__('admin.resolution'))
                ->schema([
                   Select::make('solved_by')
                        ->label(__('admin.assigned_to'))
                        ->options(
                            User::whereHas('roles', function ($query) {
                                $query->where('name', 'employee');
                            })->pluck('name', 'id')
                        )
                        ->searchable()
                        ->preload()
                        ->nullable(),

                    DateTimePicker::make('solved_at')
                        ->label(__('admin.solved_at'))
                        ->nullable(),

                    Hidden::make('reported_by')
                        ->default(Auth::id()),
                ])
                ->columns(2),
            ]);
    }
}
