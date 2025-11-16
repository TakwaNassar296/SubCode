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
                        ->title(__('admin.new_problem_assigned'))
                        ->body(__('admin.new_problem_assigned_body', [
                            'problem' => $problem->title,
                            'reporter' => $reporter->name,
                        ]))
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
                        ->title(__('admin.problem_assigned_to_you'))
                        ->body(__('admin.problem_assigned_to_you_body', [
                            'problem' => $problem->title,
                            'updater' => $updater->name,
                        ]))
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
                        ->title(__('admin.problem_solved'))
                        ->body(__('admin.problem_solved_body', [
                            'problem' => $problem->title,
                            'updater' => $updater->name,
                        ]))
                        ->success()
                        ->toDatabase()
                );
            }
        }
    }
}
