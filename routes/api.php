<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\LikeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->apiResource('ideas', IdeaController::class);

// delete
Route::middleware(['auth:sanctum'])->delete('/ideas', [IdeaController::class, 'destroy'])->name('ideas.destroy');



// all likes
Route::middleware(['auth:sanctum'])->get('/likes', [LikeController::class, 'index'])->name('likes.index');
// specific idea's likes
Route::middleware(['auth:sanctum'])->get('/idea_likes', [LikeController::class, 'show'])->name('likes.show');

// specific idea's comments
Route::middleware(['auth:sanctum'])->get('/idea_comments', [CommentController::class, 'show'])->name('comments.show');
