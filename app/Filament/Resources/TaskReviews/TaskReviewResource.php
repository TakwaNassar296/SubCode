<?php

namespace App\Filament\Resources\TaskReviews;

use App\Filament\Resources\TaskReviews\Pages\CreateTaskReview;
use App\Filament\Resources\TaskReviews\Pages\EditTaskReview;
use App\Filament\Resources\TaskReviews\Pages\ListTaskReviews;
use App\Filament\Resources\TaskReviews\Pages\ViewTaskReview;
use App\Filament\Resources\TaskReviews\Schemas\TaskReviewForm;
use App\Filament\Resources\TaskReviews\Schemas\TaskReviewInfolist;
use App\Filament\Resources\TaskReviews\Tables\TaskReviewsTable;
use App\Models\TaskReview;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskReviewResource extends Resource
{
    protected static ?string $model = TaskReview::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'TaskReview';


    public static function getNavigationLabel(): string
    {
        return __('admin.task_reviews'); 
    }

    public static function getModelLabel(): string
    {
        return __('admin.task_reviews');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('admin.task_reviews');
    }
    public static function getNavigationGroup(): string
    {
        return __('admin.team_management');
    }


    public static function form(Schema $schema): Schema
    {
        return TaskReviewForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TaskReviewInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TaskReviewsTable::configure($table);
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
            'index' => ListTaskReviews::route('/'),
            'create' => CreateTaskReview::route('/create'),
            'view' => ViewTaskReview::route('/{record}'),
            'edit' => EditTaskReview::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
