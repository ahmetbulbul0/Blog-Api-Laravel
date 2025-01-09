<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentsController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\AdminController;

Route::prefix('auth')->group(function () {
    Route::post('register/admin', [AuthController::class, 'registerAdmin']);
    Route::post('register/author', [AuthController::class, 'registerAuthor']);
    Route::post('register/reader', [AuthController::class, 'registerReader']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('authors')->group(function () {
        Route::post('/{id}/follow', [FollowController::class, 'follow'])->middleware('role:reader');
        Route::delete('/{id}/unfollow', [FollowController::class, 'unfollow'])->middleware('role:reader');
        Route::get('/{id}/followers', [FollowController::class, 'followers'])->middleware('role:author');
    });

    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/users', [AdminController::class, 'users']);
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
        Route::put('/settings', [AdminController::class, 'updateSettings']);
    });
});

Route::prefix('users')->controller(UserController::class)->group(function () {
    Route::get("/", "index");
    Route::post("/", "store");
    Route::get("{id}", "show");
    Route::put("{id}", "update");
    Route::delete("{id}", "destroy");
    Route::get("{id}/posts", "userPosts");
    Route::get("{id}/comments", "userComments");
    Route::get("{userId}/roles/{roleId}", "assignRole");
    Route::delete("{userId}/roles/{roleId}", "removeRole");
});

Route::prefix('comments')->controller(CommentsController::class)->group(function () {
    Route::get("/", "index");
    Route::post("/", "store");
    Route::get("{id}", "show");
    Route::put("{id}", "update");
    Route::delete("{id}", "destroy");
    Route::get("recent", "recentComments");
    Route::patch("{id}/approve", "approve");
    Route::patch("{id}/reject", "reject");
});

Route::prefix('posts')->controller(PostController::class)->group(function () {
    Route::post("/", "index");
    Route::post("/", "store");
    Route::get("{id}", "show");
    Route::put("{id}", "update");
    Route::delete("{id}", "destroy");
    Route::get("published", "publishedPosts");
    Route::get("drafts", "draftPosts");
    Route::get("archived", "archivedPosts");
    Route::get("popular", "popularPosts");
    Route::get("recent", "recentPosts");
    Route::get("{id}/related", "relatedPosts");
    Route::get("{id}/comments", "comments");
});
