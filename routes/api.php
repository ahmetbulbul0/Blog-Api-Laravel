<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;

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
}); 