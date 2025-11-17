<?php

namespace App\Filament\Resources\Tasks\Pages;

use Carbon\Carbon;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Tasks\TaskResource;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(__('admin.all'))
                ->modifyQueryUsing(fn (Builder $query) => $query->withoutTrashed()),
                
            'today' => Tab::make(__('admin.today'))
            ->modifyQueryUsing(fn (Builder $query) => $query->whereDate('created_at', Carbon::today())),

            'this_week' => Tab::make(__('admin.this_week'))
                ->modifyQueryUsing(fn (Builder $query) => $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])),

            'this_month' => Tab::make(__('admin.this_month'))
                ->modifyQueryUsing(fn (Builder $query) => $query->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)),
        
        ];
    }
}
