<?php

namespace App\Filament\Resources\Tasks\Schemas;

use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.status_and_due'))
                    ->schema([
                        
                        Select::make('status')
                            ->label(__('admin.status'))
                            ->options([
                                'pending' => __('admin.pending'),
                                'in_progress' => __('admin.in_progress'),
                                'completed' => __('admin.completed'),
                                'needs_review' => __('admin.needs_review'),
                            ])
                            ->default('pending')
                            ->required(),

                        DatePicker::make('due_date')
                            ->label(__('admin.due_date')),


                        TextInput::make('link')
                            ->label('Task Link')
                            ->url()
                            ->nullable()
                            ->columnSpanFull()
                            ->suffixIcon('heroicon-o-link'),
                    ])
                    ->columns(2),

                Section::make(__('admin.project_assignment'))
                    ->schema([
                        Select::make('project_id')
                            ->label(__('admin.project'))
                            ->options(function () {
                                $user = auth()->user();
                                
                                if (!$user) {
                                    return [];
                                }
                                $projectIds = $user->projects()->pluck('projects.id');
                                
                                return \App\Models\Project::whereIn('id', $projectIds)
                                    ->pluck('name', 'id')
                                    ->toArray();
                            })
                            ->required()
                            ->searchable()
                            ->preload(),

                        Hidden::make('user_id')
                            ->default(Auth::id()),
                    ]),

                Section::make(__('admin.task_information'))
                    ->schema([
                        TextInput::make('title')
                            ->label(__('admin.title'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        RichEditor::make('description')
                            ->label(__('admin.description'))
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
    
            ]);
    }
}
