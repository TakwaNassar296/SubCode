<?php

namespace App\Filament\Resources\Tasks\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
               TextColumn::make('title')
                ->label(__('admin.title'))
                ->searchable()
                ->limit(50),


                TextColumn::make('description')
                ->label(__('admin.description'))
                ->searchable()
                ->limit(50)
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('project.name')
                ->label(__('admin.project'))
                ->sortable(),

            TextColumn::make('status')
                ->label(__('admin.status'))
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'pending' => 'gray',
                    'in_progress' => 'warning',
                    'completed' => 'success',
                    'needs_review' => 'danger',
                }),

            TextColumn::make('user.name')
                ->label(__('admin.employee'))
                ->sortable(),

            TextColumn::make('due_date')
                ->label(__('admin.due_date'))
                ->date()
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
                 SelectFilter::make('status')
                ->label(__('admin.status'))
                ->options([
                    'pending' => __('admin.pending'),
                    'in_progress' => __('admin.in_progress'),
                    'completed' => __('admin.completed'),
                    'needs_review' => __('admin.needs_review'),
                ]),

            SelectFilter::make('project_id')
                ->label(__('admin.project'))
                ->relationship('project', 'name'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
              
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportAction::make(),
                ]),
            ]);
    }
}
