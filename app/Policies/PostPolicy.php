<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function viewAny(?User $user): bool
    {
        return true; // Herkes blog yazılarını görebilir
    }

    public function view(?User $user, Post $post): bool
    {
        if ($post->status === 'published') {
            return true;
        }

        if (!$user) {
            return false;
        }

        return $user->isAdmin() || $post->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isAuthor();
    }

    public function update(User $user, Post $post): bool
    {
        return $user->isAdmin() || $post->user_id === $user->id;
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->isAdmin() || $post->user_id === $user->id;
    }

    public function restore(User $user, Post $post): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Post $post): bool
    {
        return $user->isAdmin();
    }
}
