<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PostViewController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    // Post routes
    Route::get('posts/published', [PostController::class, 'published']);
    Route::get('posts/drafts', [PostController::class, 'drafts']);
    Route::get('posts/archived', [PostController::class, 'archived']);
    Route::apiResource('posts', PostController::class);

    // Category routes
    Route::get('categories/parent', [CategoryController::class, 'parentCategories']);
    Route::get('categories/{id}/sub', [CategoryController::class, 'subCategories']);
    Route::get('categories/{id}/posts', [CategoryController::class, 'categoryPosts']);
    Route::apiResource('categories', CategoryController::class);

    // Tag routes
    Route::get('tags/popular', [TagController::class, 'popularTags']);
    Route::get('tags/{id}/posts', [TagController::class, 'tagPosts']);
    Route::apiResource('tags', TagController::class);

    // Comment routes
    Route::get('comments/recent', [CommentController::class, 'recentComments']);
    Route::get('posts/{postId}/comments', [CommentController::class, 'postComments']);
    Route::get('users/{userId}/comments', [CommentController::class, 'userComments']);
    Route::patch('comments/{id}/approve', [CommentController::class, 'approve']);
    Route::patch('comments/{id}/reject', [CommentController::class, 'reject']);
    Route::apiResource('comments', CommentController::class);

    // User routes
    Route::get('users/{id}/posts', [UserController::class, 'userPosts']);
    Route::get('users/{id}/comments', [UserController::class, 'userComments']);
    Route::post('users/{userId}/roles/{roleId}', [UserController::class, 'assignRole']);
    Route::delete('users/{userId}/roles/{roleId}', [UserController::class, 'removeRole']);
    Route::apiResource('users', UserController::class);

    // Role routes
    Route::get('roles/{id}/users', [RoleController::class, 'roleUsers']);
    Route::get('roles/{id}/users/count', [RoleController::class, 'usersCount']);
    Route::apiResource('roles', RoleController::class);

    // PostView routes
    Route::get('post-views/most-viewed', [PostViewController::class, 'mostViewedPosts']);
    Route::get('posts/{postId}/views', [PostViewController::class, 'postViews']);
    Route::get('posts/{postId}/views/count', [PostViewController::class, 'viewsCount']);
    Route::get('posts/{postId}/views/date-range', [PostViewController::class, 'viewsByDateRange']);
    Route::get('users/{userId}/views', [PostViewController::class, 'userViews']);
    Route::apiResource('post-views', PostViewController::class)->except(['update']);
});
