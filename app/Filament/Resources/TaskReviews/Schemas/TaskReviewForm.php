<?php

namespace App\Filament\Resources\TaskReviews\Schemas;

use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class TaskReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.review_information'))
                ->schema([
                    Select::make('task_id')
                        ->label(__('admin.task'))
                        ->relationship('task', 'title')
                        ->required()
                        ->searchable()
                        ->preload(),

                    Textarea::make('notes')
                        ->label(__('admin.notes'))
                        ->required()
                        ->rows(3)
                        ->maxLength(1000),

                    Select::make('rating')
                        ->label(__('admin.rating'))
                        ->options([
                            1 => __('admin.one_star'),
                            2 => __('admin.two_stars'),
                            3 => __('admin.three_stars'),
                            4 => __('admin.four_stars'),
                            5 => __('admin.five_stars'),
                        ])
                        ->nullable(),

                    Hidden::make('reviewer_id')
                        ->default(Auth::id()),
                ])
                ->columns(1)
                ->columnSpanFull(),
            ]);
    }
}
