<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReactionController;

Route::prefix('posts')->group(function () {
    Route::get('/all', [PostController::class, 'allPosts']);
    Route::get('/', [PostController::class, 'index']);
    Route::get('/{id}', [PostController::class, 'show']);
    Route::post('/', [PostController::class, 'store']);
    Route::put('/{id}', [PostController::class, 'update']);
    Route::delete('/{id}', [PostController::class, 'destroy']);
});


Route::prefix('reactions')->group(function () {
    Route::post('/toggle-like', [ReactionController::class, 'toggleLike']);
});

Route::prefix('comments')->group(function () {
    Route::get('/{id}', [CommentController::class, 'show']);
    Route::post('/', [CommentController::class, 'store']);
});
