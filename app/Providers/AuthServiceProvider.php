<?php

namespace App\Providers;

// Models
use App\Models\Tag;
use App\Models\Role;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use App\Models\PostView;
use App\Models\UserFollow;

// Policies
use App\Policies\TagPolicy;
use App\Policies\RolePolicy;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use App\Policies\CommentPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\PostViewPolicy;
use App\Policies\UserFollowPolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Comment::class => CommentPolicy::class,
        Post::class => PostPolicy::class,
        PostView::class => PostViewPolicy::class,
        Role::class => RolePolicy::class,
        Tag::class => TagPolicy::class,
        User::class => UserPolicy::class,
        UserFollow::class => UserFollowPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
