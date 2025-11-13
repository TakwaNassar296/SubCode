<?php

namespace App\Filament\Resources\TaskReviews\Schemas;

use App\Models\TaskReview;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class TaskReviewInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.review_information'))
                    ->schema([
                        TextEntry::make('task.title')
                            ->label(__('admin.task'))
                            ->placeholder('-'),

                        TextEntry::make('reviewer.name')
                            ->label(__('admin.reviewer'))
                            ->placeholder('-'),

                        TextEntry::make('notes')
                            ->label(__('admin.notes'))
                            ->placeholder('-'),

                        TextEntry::make('rating')
                            ->label(__('admin.rating'))
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
