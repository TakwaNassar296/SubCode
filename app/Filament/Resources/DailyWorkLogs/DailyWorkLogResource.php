<?php

namespace App\Filament\Resources\DailyWorkLogs;

use App\Filament\Resources\DailyWorkLogs\Pages\CreateDailyWorkLog;
use App\Filament\Resources\DailyWorkLogs\Pages\EditDailyWorkLog;
use App\Filament\Resources\DailyWorkLogs\Pages\ListDailyWorkLogs;
use App\Filament\Resources\DailyWorkLogs\Pages\ViewDailyWorkLog;
use App\Filament\Resources\DailyWorkLogs\Schemas\DailyWorkLogForm;
use App\Filament\Resources\DailyWorkLogs\Schemas\DailyWorkLogInfolist;
use App\Filament\Resources\DailyWorkLogs\Tables\DailyWorkLogsTable;
use App\Models\DailyWorkLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DailyWorkLogResource extends Resource
{
    protected static ?string $model = DailyWorkLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'DailyWorkLog';


    public static function getNavigationLabel(): string
    {
        return __('admin.daily_work_logs');
    }

    public static function getModelLabel(): string
    {
        return __('admin.daily_work_log');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('admin.daily_work_logs');
    }

    public static function getNavigationGroup(): string
    {
        return __('admin.team_management');
    }

    public static function form(Schema $schema): Schema
    {
        return DailyWorkLogForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DailyWorkLogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DailyWorkLogsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDailyWorkLogs::route('/'),
            'create' => CreateDailyWorkLog::route('/create'),
            'view' => ViewDailyWorkLog::route('/{record}'),
            'edit' => EditDailyWorkLog::route('/{record}/edit'),
        ];
    }
}
