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
                    ->title('New Task Review')
                    ->body("Your task '{$taskReview->task->title}' has been reviewed by {$reviewer->name}. Notes: {$taskReview->notes}")
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
                $ratingText = $taskReview->rating ? "Rating: {$taskReview->rating}/5" : "";
                
                $taskOwner->notify(
                    Notification::make()
                        ->title('Task Review Updated')
                        ->body("Your task '{$taskReview->task->title}' review was updated by {$reviewer->name}. {$ratingText}")
                        ->info()
                        ->toDatabase()
                );
            }
        }
    }
}