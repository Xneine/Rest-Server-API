<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\pemilikPostingan;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Middleware\PemilikKomentar;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/me', [AuthenticationController::class, 'me']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::patch('/posts/{id}', [PostController::class, 'update'])->middleware(pemilikPostingan::class);
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->middleware(pemilikPostingan::class);

    Route::post('/comment', [CommentController::class, 'store']);
    Route::patch('/comment/{id}', [CommentController::class, 'update'])->middleware(PemilikKomentar::class);
    Route::delete('/comment/{id}', [CommentController::class, 'destroy'])->middleware(PemilikKomentar::class);
});

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);

Route::post('/login', [AuthenticationController::class, 'login']);