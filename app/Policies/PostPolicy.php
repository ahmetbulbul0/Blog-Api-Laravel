<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Post $post): bool
    {
        if ($post->status === 'published' && $post->published_at <= now()) {
            return true;
        }

        if (!$user) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }

        return $post->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isAuthor();
    }

    public function update(User $user, Post $post): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isAuthor() && $post->user_id === $user->id;
    }

    public function delete(User $user, Post $post): bool
    {

        if ($user->isAdmin()) {
            return true;
        }

        return $user->isAuthor() && $post->user_id === $user->id;
    }

    public function publish(User $user, Post $post): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isAuthor() && $post->user_id === $user->id;
    }

    public function archive(User $user, Post $post): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isAuthor() && $post->user_id === $user->id;
    }

    public function viewDeleted(User $user): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Post $post): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Post $post): bool
    {
        return $user->isAdmin();
    }

    public function manageComments(User $user, Post $post): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isAuthor() && $post->user_id === $user->id;
    }

    public function viewStatistics(User $user, Post $post): bool
    {

        if ($user->isAdmin()) {
            return true;
        }

        return $user->isAuthor() && $post->user_id === $user->id;
    }

    public function viewDrafts(User $user): bool
    {
        return $user->isAdmin() || $user->isAuthor();
    }

    public function viewArchived(User $user): bool
    {
        return $user->isAdmin() || $user->isAuthor();
    }
}
