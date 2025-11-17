<?php

namespace App\Filament\Resources\Problems\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Forms\Components\DateTimePicker;
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

                TextColumn::make('status')
                ->label(__('admin.status'))
                ->badge()
                ->color(fn ($state) => match ($state) {
                    'solved' => 'success',
                    'in_progress' => 'warning',
                    'pending' => 'danger',
                    default => 'gray',
                })
                ->sortable()
                ->formatStateUsing(fn (string $state) => __('admin.' . $state)),

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
               Action::make('update_status')
                ->label(__('admin.update_status'))
                ->icon('heroicon-o-pencil')
                ->color('warning')
                ->form([
                    Select::make('status')
                        ->label(__('admin.status'))
                        ->options([
                            'pending' => __('admin.pending'),
                            'in_progress' => __('admin.in_progress'),
                            'solved' => __('admin.solved'),
                        ])
                        ->required()
                        ->default(fn ($record) => $record->status),
                        
                    DateTimePicker::make('solved_at')
                        ->label(__('admin.solved_at'))
                        ->default(now()),
                        
                    Textarea::make('notes')
                        ->label(__('admin.notes'))
                        ->rows(3)
                        ->maxLength(1000),
                ])
                ->action(function ($record, array $data) {
                    $record->update($data);
                })
                ->requiresConfirmation()
                ->modalHeading(__('Update Status'))
                ->modalDescription(__('Are you sure you want to update the status?')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ExportAction::make(),
                ]),
            ])->modifyQueryUsing(function ($query) {
                $user = auth()->user();
                if ($user->hasRole('super_admin') || $user->hasRole('manager')) {
                    return $query; 
                }
                return $query->where('solved_by', $user->id);
            });
    }
}
