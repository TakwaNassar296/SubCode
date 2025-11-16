<?php

namespace App\Filament\Widgets;

use App\Models\Problem;
use Filament\Widgets\ChartWidget;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class ProblemStatusChart extends ChartWidget
{
    use HasWidgetShield;
    protected static ?int $sort = 3;
    protected ?string $heading = null;

    protected function getData(): array
    {
        $this->heading = __('admin.problem_status');
        
        $pending = Problem::where('status', 'pending')->count();
        $inProgress = Problem::where('status', 'in_progress')->count();
        $solved = Problem::where('status', 'solved')->count();

        return [
            'labels' => [
                __('admin.pending'),
                __('admin.in_progress'),
                __('admin.solved'),
            ],
            'datasets' => [
                [
                    'label' => __('admin.problem_status'),
                    'data' => [$pending, $inProgress, $solved],
                    'backgroundColor' => ['#d1d5db', '#f59e0b', '#22c55e'],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}