<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TagsController;
use App\Http\Controllers\Api\UserController;
 use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\CommentsController;
use App\Http\Controllers\Api\PostViewsController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\UserFollowsController;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::prefix("register")->group(function () {
        Route::post('admin', 'registerAdmin');
        Route::post('author', 'registerAuthor');
        Route::post('reader', 'registerReader');
    });

    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
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

Route::prefix('categories')->controller(CategoriesController::class)->group(function () {
    Route::post("/", "index");
    Route::post("/", "store");
    Route::get("{id}", "show");
    Route::put("{id}", "update");
    Route::delete("{id}", "destroy");
    Route::get("parent", "parentCategories");
    Route::get("{id}/sub", "subCategories");
    Route::get("{id}/posts", "categoryPosts");
});

Route::prefix('post-views')->controller(PostViewsController::class)->group(function () {
    Route::get("/", "index");
    Route::post("/", "store");
    Route::get("{id}", "show");
    Route::get("most-viewed", "mostViewedPosts");

    Route::prefix("by-post/{postId}")->group(function () {
        Route::get("/", "postViews");
        Route::get("count", "viewsCount");
        Route::get("date-range", "viewsByDateRange");
    });

    Route::prefix("by-user/{userId}")->group(function () {
        Route::get("/", "userViews");
    });
});

Route::prefix('roles')->controller(RolesController::class)->group(function () {
    Route::get("/", "index");
    Route::post("/", "store");
    Route::get("{id}", "show");
    Route::put("{id}", "update");
    Route::delete("{id}", "destroy");
    Route::get("{id}/users", "roleUsers");
    Route::get("{id}/users-count", "roleUsers");
})->middleware(["auth", "role:admin"]);

Route::prefix('tags')->controller(TagsController::class)->group(function () {
    Route::get("/", "index");
    Route::post("/", "store");
    Route::get("{id}", "show");
    Route::put("{id}", "update");
    Route::delete("{id}", "destroy");
    Route::get("popular", "popularTags");
    Route::get("{id}/posts", "tagPosts");
});

Route::prefix('user-follows')->controller(UserFollowsController::class)->group(function () {
    Route::post("follow/{userId}", "follow");
    Route::delete("unfollow/{userId}", "unfollow");
    Route::get("{id}/followers", "followers");
    Route::get("{id}", "followings");
})->middleware(["auth"]);
