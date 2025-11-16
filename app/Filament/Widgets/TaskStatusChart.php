<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Widgets\ChartWidget;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class TaskStatusChart extends ChartWidget
{
    use HasWidgetShield;
    protected static ?int $sort = 2;
    protected ?string $heading = 'Task Status Chart';

    protected function getData(): array
    {
        $this->heading = __('admin.task_status');

        $pending = Task::where('status', 'pending')->count();
        $inProgress = Task::where('status', 'in_progress')->count();
        $completed = Task::where('status', 'completed')->count();
        $needsReview = Task::where('status', 'needs_review')->count();

        return [
            'labels' => [
                __('admin.pending'),
                __('admin.in_progress'),
                __('admin.completed'),
                __('admin.needs_review'),
            ],
            'datasets' => [
                [
                    'label' => __('admin.task_status'),
                    'data' => [$pending, $inProgress, $completed, $needsReview],
                    'backgroundColor' => [
                        '#d1d5db', // pending - gray
                        '#f59e0b', // in_progress - amber
                        '#22c55e', // completed - green
                        '#ef4444', // needs_review - red
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}