<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Tag $tag): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isAuthor();
    }

    public function update(User $user, Tag $tag): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isAuthor()) {
            return $tag->posts()->count() === 0;
        }

        return false;
    }

    public function delete(User $user, Tag $tag): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isAuthor()) {
            return $tag->posts()->count() === 0;
        }

        return false;
    }

    public function viewPopular(?User $user): bool
    {
        return true;
    }

    public function viewStatistics(User $user): bool
    {
        return $user->isAdmin() || $user->isAuthor();
    }

    public function viewPosts(?User $user, Tag $tag): bool
    {
        return true;
    }

    public function merge(User $user): bool
    {
        return $user->isAdmin();
    }

    public function viewSuggestions(?User $user): bool
    {
        return true;
    }

    public function viewTrends(User $user): bool
    {
        return $user->isAdmin() || $user->isAuthor();
    }

    public function manage(User $user): bool
    {
        return $user->isAdmin();
    }
}
