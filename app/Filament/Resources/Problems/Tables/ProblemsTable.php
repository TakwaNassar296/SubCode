<?php

namespace App\Filament\Resources\Problems\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ForceDeleteBulkAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class ProblemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                ->label(__('admin.title'))
                ->searchable()
                ->limit(50),

            TextColumn::make('reportedBy.name')
                ->label(__('admin.reported_by'))
                ->sortable(),

            TextColumn::make('solvedBy.name')
                ->label(__('admin.solved_by'))
                ->sortable()
                ->toggleable(),

            TextColumn::make('solved_at')
                ->label(__('admin.solved_at'))
                ->dateTime()
                ->sortable()
                ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),

                SelectFilter::make('task_id')
                ->label(__('admin.task'))
                ->relationship('task', 'title'),

            Filter::make('unsolved')
                ->label(__('admin.unsolved_problems'))
                ->query(fn ($query) => $query->whereNull('solved_at')),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ExportAction::make(),
                ]),
            ]);
    }
}
