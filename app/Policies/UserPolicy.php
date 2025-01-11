<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(?User $user, User $targetUser): bool
    {
        if ($targetUser->isAuthor()) {
            return true;
        }

        if ($user && $user->id === $targetUser->id) {
            return true;
        }

        if ($user && $user->isAdmin()) {
            return true;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, User $targetUser): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id === $targetUser->id;
    }

    public function delete(User $user, User $targetUser): bool
    {
        if ($user->isAdmin() && $user->id !== $targetUser->id) {
            return true;
        }

        return $user->id === $targetUser->id;
    }

    public function follow(User $user, User $targetUser): bool
    {
        if ($user->id === $targetUser->id) {
            return false;
        }

        return $targetUser->isAuthor();
    }

    public function unfollow(User $user, User $targetUser): bool
    {
        return $user->followedAuthors()->where('author_id', $targetUser->id)->exists();
    }

    public function viewStatistics(User $user, User $targetUser): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id === $targetUser->id;
    }

    public function changeRole(User $user, User $targetUser): bool
    {
        return $user->isAdmin() && $user->id !== $targetUser->id;
    }

    public function ban(User $user, User $targetUser): bool
    {
        return $user->isAdmin() && $user->id !== $targetUser->id;
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

    public function viewPosts(?User $user, User $targetUser): bool
    {
        if ($targetUser->isAuthor()) {
            return true;
        }

        return false;
    }

    public function viewComments(?User $user, User $targetUser): bool
    {
        return true;
    }
}
