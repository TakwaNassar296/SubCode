<?php

namespace App\Filament\Resources\Problems\Schemas;

use App\Models\Problem;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Infolists\Components\TextEntry;

class ProblemInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.problem_information'))
                    ->schema([
                        TextEntry::make('title')
                            ->label(__('admin.title')),

                        TextEntry::make('description')
                            ->label(__('admin.description'))
                            ->placeholder('-')
                            ->html(),

                        TextEntry::make('task.title')
                            ->label(__('admin.related_task'))
                            ->placeholder('-'),
                    ]),

                Section::make(__('admin.resolution'))
                    ->schema([
                         TextEntry::make('status')
                            ->label(__('admin.status'))
                            ->getStateUsing(fn ($record) => __('admin.' . $record->status)),

                        TextEntry::make('solved_at')
                            ->label(__('admin.solved_at'))
                            ->dateTime()
                            ->placeholder('-'),

                        TextEntry::make('notes')
                            ->label(__('admin.notes')),    

                    ]),

                Section::make(__('admin.timestamps'))
                    ->schema([

                        TextEntry::make('solvedBy.name')
                            ->label(__('admin.solved_by'))
                            ->placeholder('-'),
                        
                        TextEntry::make('reportedBy.name')
                            ->label(__('admin.reported_by'))
                            ->placeholder('-'),
                        TextEntry::make('created_at')
                            ->label(__('admin.created_at'))
                            ->dateTime()
                            ->placeholder('-'),

                        TextEntry::make('updated_at')
                            ->label(__('admin.updated_at'))
                            ->dateTime()
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
              
            ]);
    }
}
