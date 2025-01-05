<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Interfaces
use App\Interfaces\Repositories\PostRepositoryInterface;
use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Repositories\TagRepositoryInterface;
use App\Interfaces\Repositories\CommentRepositoryInterface;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Interfaces\Repositories\RoleRepositoryInterface;
use App\Interfaces\Repositories\PostViewRepositoryInterface;

// Repositories
use App\Repositories\PostRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\TagRepository;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Repositories\PostViewRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PostViewRepositoryInterface::class, PostViewRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
