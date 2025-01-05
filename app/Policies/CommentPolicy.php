<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Comment $comment): bool
    {
        if ($comment->status === 'approved') {
            return true;
        }

        if (!$user) {
            return false;
        }

        return $user->isAdmin() || $comment->user_id === $user->id;
    }

    public function create(?User $user): bool
    {
        return true; // Herkes yorum yapabilir (misafir yorumları dahil)
    }

    public function update(User $user, Comment $comment): bool
    {
        return $user->isAdmin() || $comment->user_id === $user->id;
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $user->isAdmin() || $comment->user_id === $user->id;
    }

    public function moderate(User $user): bool
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
