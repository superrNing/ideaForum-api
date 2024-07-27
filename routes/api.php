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
// detail
Route::middleware(['auth:sanctum'])->get('/idea_detail', [IdeaController::class, 'show'])->name('ideas.show');
// update
Route::middleware(['auth:sanctum'])->put('/ideas', [IdeaController::class, 'update'])->name('ideas.update');



// all likes
Route::middleware(['auth:sanctum'])->get('/likes', [LikeController::class, 'index'])->name('likes.index');
// specific idea's likes
Route::middleware(['auth:sanctum'])->get('/idea_likes', [LikeController::class, 'show'])->name('likes.show');
// add like
Route::middleware(['auth:sanctum'])->post('/likes', [LikeController::class, 'store'])->name('likes.store');
// remove like
Route::middleware(['auth:sanctum'])->delete('/likes', [LikeController::class, 'destroy'])->name('likes.destroy');


// specific idea's comments
Route::middleware(['auth:sanctum'])->get('/idea_comments', [CommentController::class, 'show'])->name('comments.show');
Route::middleware(['auth:sanctum'])->post('/comments', [CommentController::class, 'store'])->name('comments.store');
// delete
Route::middleware(['auth:sanctum'])->delete('/comments', [CommentController::class, 'destroy'])->name('comments.destroy');
