<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Task;
use App\Models\Problem;
use App\Models\DailyWorkLog;
use App\Models\Project;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    
    protected function getColumns(): int|array|null
    {
        return 2;
    }

    protected function getStats(): array
    {
        $employeeRole = Role::where('name', 'employee')->first();
        $supervisorRole = Role::where('name', 'supervisor')->first();
        $managerRole = Role::where('name', 'manager')->first();

        return [
            Stat::make(__('إجمالي الموظفين'), $employeeRole ? $employeeRole->users()->count() : 0)
                ->description(__('الموظفين النشطين'))
                ->descriptionIcon('heroicon-o-users')
                ->color('success')
                ->chart($this->getEmployeeChartData())
                ->extraAttributes(['style' => 'height: 150px']),

            Stat::make(__('إجمالي المشرفين'), $supervisorRole ? $supervisorRole->users()->count() : 0)
                ->description(__('مشرفين النظام'))
                ->descriptionIcon('heroicon-o-user-group')
                ->color('info')
                ->chart($this->getSupervisorChartData())
                ->extraAttributes(['style' => 'height: 150px']),

            Stat::make(__('إجمالي المديرين'), $managerRole ? $managerRole->users()->count() : 0)
                ->description(__('مديرين النظام'))
                ->descriptionIcon('heroicon-o-cog')
                ->color('warning')
                ->chart($this->getManagerChartData())
                ->extraAttributes(['style' => 'height: 150px']),

            Stat::make(__('إجمالي المهام'), Task::count())
                ->description(__('جميع المهام'))
                ->descriptionIcon('heroicon-o-clipboard-document-list')
                ->color('primary')
                ->chart($this->getTaskChartData())
                ->extraAttributes(['style' => 'height: 150px']),

            Stat::make(__('المهام المنجزة'), Task::where('status', 'completed')->count())
                ->description(__('مهام منجزة'))
                ->descriptionIcon('heroicon-o-check-badge')
                ->color('success')
                ->chart($this->getCompletedTaskChartData())
                ->extraAttributes(['style' => 'height: 150px']),

            Stat::make(__('المهام قيد التنفيذ'), Task::where('status', 'in_progress')->count())
                ->description(__('تحت التنفيذ'))
                ->descriptionIcon('heroicon-o-cog')
                ->color('warning')
                ->chart($this->getInProgressTaskChartData())
                ->extraAttributes(['style' => 'height: 150px']),

            Stat::make(__('المهام تحتاج مراجعة'), Task::where('status', 'needs_review')->count())
                ->description(__('تنتظر المراجعة'))
                ->descriptionIcon('heroicon-o-eye')
                ->color('danger')
                ->chart($this->getReviewTaskChartData())
                ->extraAttributes(['style' => 'height: 150px']),

            Stat::make(__('سجلات العمل اليومية'), DailyWorkLog::count())
                ->description(__('إدخالات العمل'))
                ->descriptionIcon('heroicon-o-document-text')
                ->color('info')
                ->chart($this->getWorkLogChartData())
                ->extraAttributes(['style' => 'height: 150px']),

            Stat::make(__('المشكلات المفتوحة'), Problem::count())
                ->description(__('مشكلات تحتاج حل'))
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color('danger')
                ->chart($this->getProblemChartData())
                ->extraAttributes(['style' => 'height: 150px']),

            Stat::make(__('إجمالي المشاريع'), Project::count())
                ->description(__('المشاريع النشطة'))
                ->descriptionIcon('heroicon-o-folder')
                ->color('primary')
                ->chart($this->getProjectChartData())
                ->extraAttributes(['style' => 'height: 150px']),
        ];
    }

    protected function getEmployeeChartData(): array
    {
        $employeeRole = Role::where('name', 'employee')->first();
        
        return collect(range(6, 0))
            ->map(function($i) use ($employeeRole) {
                if (!$employeeRole) return 0;
                
                return $employeeRole->users()
                    ->whereDate('created_at', Carbon::today()->subDays($i))
                    ->count();
            })
            ->toArray();
    }

    protected function getSupervisorChartData(): array
    {
        $supervisorRole = Role::where('name', 'supervisor')->first();
        
        return collect(range(6, 0))
            ->map(function($i) use ($supervisorRole) {
                if (!$supervisorRole) return 0;
                
                return $supervisorRole->users()
                    ->whereDate('created_at', Carbon::today()->subDays($i))
                    ->count();
            })
            ->toArray();
    }

    protected function getManagerChartData(): array
    {
        $managerRole = Role::where('name', 'manager')->first();
        
        return collect(range(6, 0))
            ->map(function($i) use ($managerRole) {
                if (!$managerRole) return 0;
                
                return $managerRole->users()
                    ->whereDate('created_at', Carbon::today()->subDays($i))
                    ->count();
            })
            ->toArray();
    }

    protected function getTaskChartData(): array
    {
        return collect(range(6, 0))
            ->map(fn($i) => Task::whereDate('created_at', Carbon::today()->subDays($i))->count())
            ->toArray();
    }

    protected function getCompletedTaskChartData(): array
    {
        return collect(range(6, 0))
            ->map(fn($i) => Task::where('status', 'completed')->whereDate('created_at', Carbon::today()->subDays($i))->count())
            ->toArray();
    }

    protected function getInProgressTaskChartData(): array
    {
        return collect(range(6, 0))
            ->map(fn($i) => Task::where('status', 'in_progress')->whereDate('created_at', Carbon::today()->subDays($i))->count())
            ->toArray();
    }

    protected function getReviewTaskChartData(): array
    {
        return collect(range(6, 0))
            ->map(fn($i) => Task::where('status', 'needs_review')->whereDate('created_at', Carbon::today()->subDays($i))->count())
            ->toArray();
    }

    protected function getWorkLogChartData(): array
    {
        return collect(range(6, 0))
            ->map(fn($i) => DailyWorkLog::whereDate('created_at', Carbon::today()->subDays($i))->count())
            ->toArray();
    }

    protected function getProblemChartData(): array
    {
        return collect(range(6, 0))
            ->map(fn($i) => Problem::whereDate('created_at', Carbon::today()->subDays($i))->count())
            ->toArray();
    }

    protected function getProjectChartData(): array
    {
        return collect(range(6, 0))
            ->map(fn($i) => Project::whereDate('created_at', Carbon::today()->subDays($i))->count())
            ->toArray();
    }
}