<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Interfaces
use App\Interfaces\Services\CategoryServiceInterface;
use App\Interfaces\Services\TagServiceInterface;
use App\Interfaces\Services\CommentServiceInterface;
use App\Interfaces\Services\UserServiceInterface;
use App\Interfaces\Services\RoleServiceInterface;
use App\Interfaces\Services\PostViewServiceInterface;
use App\Interfaces\Services\PostServiceInterface;

// Services
use App\Services\CategoryService;
use App\Services\TagService;
use App\Services\CommentService;
use App\Services\UserService;
use App\Services\RoleService;
use App\Services\PostViewService;
use App\Services\PostService;

class ServiceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(TagServiceInterface::class, TagService::class);
        $this->app->bind(CommentServiceInterface::class, CommentService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(PostViewServiceInterface::class, PostViewService::class);
        $this->app->bind(PostServiceInterface::class, PostService::class);
    }

    public function boot(): void
    {
        //
    }
}
