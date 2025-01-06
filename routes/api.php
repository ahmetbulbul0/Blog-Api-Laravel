<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PostViewController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::prefix('auth')->controller(AuthController::class)->name("auth.")->group(function () {
    Route::post('register', 'register')->name("register");
    Route::post('login', 'login')->name("login");
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });

    // Post routes
    Route::prefix('posts')->group(function () {
        Route::get('published', [PostController::class, 'published']);
        Route::get('drafts', [PostController::class, 'drafts']);
        Route::get('archived', [PostController::class, 'archived']);
        Route::get('{id}/views', [PostViewController::class, 'postViews']);
        Route::get('{id}/views/count', [PostViewController::class, 'viewsCount']);
        Route::get('{id}/views/date-range', [PostViewController::class, 'viewsByDateRange']);
    });
    Route::apiResource('posts', PostController::class);

    // Category routes
    Route::prefix('categories')->group(function () {
        Route::get('parent', [CategoryController::class, 'parentCategories']);
        Route::get('{id}/sub', [CategoryController::class, 'subCategories']);
        Route::get('{id}/posts', [CategoryController::class, 'categoryPosts']);
    });
    Route::apiResource('categories', CategoryController::class);

    // Tag routes
    Route::prefix('tags')->group(function () {
        Route::get('popular', [TagController::class, 'popularTags']);
        Route::get('{id}/posts', [TagController::class, 'tagPosts']);
    });
    Route::apiResource('tags', TagController::class);

    // Comment routes
    Route::prefix('comments')->group(function () {
        Route::get('recent', [CommentController::class, 'recentComments']);
        Route::patch('{id}/approve', [CommentController::class, 'approve']);
        Route::patch('{id}/reject', [CommentController::class, 'reject']);
    });
    Route::apiResource('comments', CommentController::class);

    // User routes
    Route::prefix('users')->group(function () {
        Route::get('{id}/posts', [UserController::class, 'userPosts']);
        Route::get('{id}/comments', [UserController::class, 'userComments']);
        Route::get('{id}/views', [PostViewController::class, 'userViews']);
        Route::post('{userId}/roles/{roleId}', [UserController::class, 'assignRole']);
        Route::delete('{userId}/roles/{roleId}', [UserController::class, 'removeRole']);
    });
    Route::apiResource('users', UserController::class);

    // Role routes
    Route::prefix('roles')->group(function () {
        Route::get('{id}/users', [RoleController::class, 'roleUsers']);
        Route::get('{id}/users/count', [RoleController::class, 'usersCount']);
    });
    Route::apiResource('roles', RoleController::class);

    // PostView routes
    Route::prefix('post-views')->group(function () {
        Route::get('most-viewed', [PostViewController::class, 'mostViewedPosts']);
    });
    Route::apiResource('post-views', PostViewController::class)->except(['update']);
});
