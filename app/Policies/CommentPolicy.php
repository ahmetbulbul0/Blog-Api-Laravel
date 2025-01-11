<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Comment $comment): bool
    {
        if ($comment->status === 'approved') {
            return true;
        }

        if ($user) {
            return $user->isAdmin() || $comment->user_id === $user->id;
        }

        return false;
    }

    public function create(?User $user): bool
    {
        return true;
    }

    public function update(User $user, Comment $comment): bool
    {
        if ($user->isAdmin()) {
            return true;
        }


        if ($comment->user_id === $user->id) {

            return $comment->created_at->diffInMinutes(now()) <= 30;
        }

        return false;
    }

    public function delete(User $user, Comment $comment): bool
    {

        if ($user->isAdmin()) {
            return true;
        }


        return $comment->user_id === $user->id;
    }

    public function approve(User $user, Comment $comment): bool
    {
        return $user->isAdmin();
    }

    public function markAsSpam(User $user, Comment $comment): bool
    {
        return $user->isAdmin();
    }

    public function viewDeleted(User $user): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Comment $comment): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Comment $comment): bool
    {
        return $user->isAdmin();
    }
}
