<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\DailyWorkLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class DailyWorkLogPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DailyWorkLog');
    }

    public function view(AuthUser $authUser, DailyWorkLog $dailyWorkLog): bool
    {
        return $authUser->can('View:DailyWorkLog');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DailyWorkLog');
    }

    public function update(AuthUser $authUser, DailyWorkLog $dailyWorkLog): bool
    {
        return $authUser->can('Update:DailyWorkLog');
    }

    public function delete(AuthUser $authUser, DailyWorkLog $dailyWorkLog): bool
    {
        return $authUser->can('Delete:DailyWorkLog');
    }

    public function restore(AuthUser $authUser, DailyWorkLog $dailyWorkLog): bool
    {
        return $authUser->can('Restore:DailyWorkLog');
    }

    public function forceDelete(AuthUser $authUser, DailyWorkLog $dailyWorkLog): bool
    {
        return $authUser->can('ForceDelete:DailyWorkLog');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:DailyWorkLog');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:DailyWorkLog');
    }

    public function replicate(AuthUser $authUser, DailyWorkLog $dailyWorkLog): bool
    {
        return $authUser->can('Replicate:DailyWorkLog');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:DailyWorkLog');
    }

}