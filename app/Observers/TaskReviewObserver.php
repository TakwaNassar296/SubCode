<?php 

namespace App\Observers;

use App\Models\TaskReview;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class TaskReviewObserver
{
    public function created(TaskReview $taskReview): void
    {
        $reviewer = Auth::user();
        $taskOwner = $taskReview->task->user;
        
        if ($taskOwner) {
            $taskOwner->notify(
                Notification::make()
                    ->title(__('admin.new_task_review'))
                    ->body(__('admin.new_task_review_body', [
                        'task' => $taskReview->task->title,
                        'reviewer' => $reviewer->name,
                        'notes' => $taskReview->notes,
                    ]))
                    ->success()
                    ->toDatabase()
            );
        }
    }

    public function updated(TaskReview $taskReview): void
    {
        $reviewer = Auth::user();

        if ($taskReview->isDirty('rating') || $taskReview->isDirty('notes')) {
            $taskOwner = $taskReview->task->user;
            
            if ($taskOwner) {
                $ratingText = $taskReview->rating ? __('admin.rating_text', ['rating' => $taskReview->rating]) : '';

                $taskOwner->notify(
                    Notification::make()
                        ->title(__('admin.task_review_updated'))
                        ->body(__('admin.task_review_updated_body', [
                            'task' => $taskReview->task->title,
                            'reviewer' => $reviewer->name,
                            'rating' => $ratingText,
                        ]))
                        ->info()
                        ->toDatabase()
                );
            }
        }
    }
}
