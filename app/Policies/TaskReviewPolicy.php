<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\TaskReview;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskReviewPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TaskReview');
    }

    public function view(AuthUser $authUser, TaskReview $taskReview): bool
    {
        return $authUser->can('View:TaskReview');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TaskReview');
    }

    public function update(AuthUser $authUser, TaskReview $taskReview): bool
    {
        return $authUser->can('Update:TaskReview');
    }

    public function delete(AuthUser $authUser, TaskReview $taskReview): bool
    {
        return $authUser->can('Delete:TaskReview');
    }

    public function restore(AuthUser $authUser, TaskReview $taskReview): bool
    {
        return $authUser->can('Restore:TaskReview');
    }

    public function forceDelete(AuthUser $authUser, TaskReview $taskReview): bool
    {
        return $authUser->can('ForceDelete:TaskReview');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TaskReview');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TaskReview');
    }

    public function replicate(AuthUser $authUser, TaskReview $taskReview): bool
    {
        return $authUser->can('Replicate:TaskReview');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TaskReview');
    }

}