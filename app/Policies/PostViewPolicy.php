<?php

namespace App\Policies;

use App\Models\PostView;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostViewPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, PostView $postView): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isAuthor()) {
            return $postView->post->user_id === $user->id;
        }

        return $postView->user_id === $user->id;
    }

    public function create(?User $user): bool
    {
        return true;
    }

    public function update(User $user, PostView $postView): bool
    {
        return false;
    }

    public function delete(User $user, PostView $postView): bool
    {
        return $user->isAdmin();
    }

    public function viewStatistics(User $user, PostView $postView): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isAuthor()) {
            return $postView->post->user_id === $user->id;
        }

        return false;
    }

    public function viewDateRangeStatistics(User $user, PostView $postView): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isAuthor()) {
            return $postView->post->user_id === $user->id;
        }

        return false;
    }

    public function viewIpStatistics(User $user): bool
    {
        return $user->isAdmin();
    }

    public function viewUserStatistics(User $user, ?User $targetUser = null): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($targetUser && $user->id === $targetUser->id) {
            return true;
        }

        return $user->isAuthor();
    }
}
