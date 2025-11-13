<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
               TextColumn::make('name')
                ->label(__('admin.name'))
                ->searchable(),

               TextColumn::make('email')
                ->label(__('admin.email'))
                ->searchable(),

            TextColumn::make('roles.name')
                ->label(__('admin.assign_roles'))
                ->sortable()
                ->wrap()
                ->separator(', ')
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('github_account')
                ->label(__('admin.github_account'))
                ->limit(20)
                ->toggleable(),

            TextColumn::make('working_hours')
                ->label(__('admin.working_hours'))
                ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('role')
                    ->searchable(),
                TextColumn::make('github_account')
                    ->searchable(),
                TextColumn::make('working_hours')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
