<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserFollow;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserFollowPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, UserFollow $userFollow): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id === $userFollow->follower_id || $user->id === $userFollow->author_id;
    }

    public function create(User $user, User $targetUser): bool
    {
        if ($user->id === $targetUser->id) {
            return false;
        }

        if (!$targetUser->isAuthor()) {
            return false;
        }

        if ($user->followedAuthors()->where('author_id', $targetUser->id)->exists()) {
            return false;
        }

        return true;
    }

    public function update(User $user, UserFollow $userFollow): bool
    {
        return false;
    }

    public function delete(User $user, UserFollow $userFollow): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id === $userFollow->follower_id;
    }

    public function viewFollowers(?User $user, User $targetUser): bool
    {
        if ($targetUser->isAuthor()) {
            return true;
        }

        if ($user && $user->id === $targetUser->id) {
            return true;
        }

        return $user && $user->isAdmin();
    }

    public function viewFollowing(?User $user, User $targetUser): bool
    {
        if ($user && $user->id === $targetUser->id) {
            return true;
        }

        return $user && $user->isAdmin();
    }

    public function viewStatistics(User $user, User $targetUser): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->id === $targetUser->id && $user->isAuthor()) {
            return true;
        }

        return false;
    }

    public function viewSuggestions(?User $user): bool
    {
        return $user !== null;
    }

    public function bulkOperations(User $user): bool
    {
        return $user->isAdmin();
    }
}
