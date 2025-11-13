<?php

namespace App\Observers;

use App\Models\Problem;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ProblemObserver
{
    public function created(Problem $problem): void
    {
        $reporter = Auth::user();

        if ($problem->solved_by) {
            $assignee = $problem->solvedBy;
            
            if ($assignee) {
                $assignee->notify(
                    Notification::make()
                        ->title('New Problem Assigned')
                        ->body("You have been assigned a new problem: '{$problem->title}' by {$reporter->name}")
                        ->warning()
                        ->toDatabase()
                );
            }
        }
    }

    public function updated(Problem $problem): void
    {
        $updater = Auth::user();

        if ($problem->isDirty('solved_by') && $problem->solved_by) {
            $assignee = $problem->solvedBy;
            
            if ($assignee) {
                $assignee->notify(
                    Notification::make()
                        ->title('Problem Assigned to You')
                        ->body("Problem '{$problem->title}' has been assigned to you by {$updater->name}")
                        ->warning()
                        ->toDatabase()
                );
            }
        }

        if ($problem->isDirty('solved_at') && $problem->solved_at) {
            $reporter = $problem->reportedBy;
            
            if ($reporter) {
                $reporter->notify(
                    Notification::make()
                        ->title('Problem Solved')
                        ->body("Problem '{$problem->title}' has been solved by {$updater->name}")
                        ->success()
                        ->toDatabase()
                );
            }
        }
    }
}