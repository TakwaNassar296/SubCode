<?php

namespace App\Filament\Resources\DailyWorkLogs\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\ForceDeleteBulkAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class DailyWorkLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
               TextColumn::make('user.name')
                    ->label(__('admin.employee'))
                    ->sortable(),

                TextColumn::make('task.title')
                    ->label(__('admin.task'))
                    ->limit(50),

                TextColumn::make('work_date')
                    ->label(__('admin.work_date'))
                    ->date()
                    ->sortable(),
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
                SelectFilter::make('user_id')
                    ->label(__('admin.employee'))
                    ->relationship('user', 'name'),
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
                    \AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction::make('export')
                ]),
            ]) ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();

                if ($user->hasRole('super_admin') || $user->hasRole('manager')) {
                    return $query;
                }

                return $query->where('user_id', $user->id);
            });
    }
}
