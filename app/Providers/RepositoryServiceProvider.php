<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Repositories\PostRepositoryInterface;
use App\Repositories\PostRepository;
use App\Interfaces\Services\PostServiceInterface;
use App\Services\PostService;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(PostServiceInterface::class, PostService::class);
    }
} 