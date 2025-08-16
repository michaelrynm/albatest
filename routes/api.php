<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\BookmarkController;


Route::get('/hello', function (){
    return response()->json([
        'message' => 'Welcome to the API'
    ]);
});

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class,'register']);
    Route::post('login',    [AuthController::class,'login']);
    Route::middleware('auth:sanctum')->post('logout', [AuthController::class,'logout']);
});

Route::middleware('auth:sanctum')->group(function () {

    // Profile (User)
    Route::get('users/me',  [UserController::class,'me']);
    Route::put('users/me',  [UserController::class,'update']);

    // Categories
    Route::apiResource('categories', CategoryController::class);

    // Posts
    Route::apiResource('posts', PostController::class);

    // Bookmarks
    Route::get('bookmarks', [BookmarkController::class,'index']);
    Route::post('posts/{post}/bookmark', [BookmarkController::class,'toggle']);
});
