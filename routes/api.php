<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AdminUserController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CommentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Route to register user
Route::post('/register', [UserController::class, 'register']);

// Route to login a user
Route::post('/login', [UserController::class, 'login']);

// route to get approved blogs
Route::get('/blogs', [BlogController::class, 'getApprovedBlogs']);

// route to add comment from guest
Route::post('/blogs/{blog_id}/guest_comments', [CommentController::class, 'guestAddComment']);



// Protected routes (authentication required)
// Route::group(['middleware'=>['auth', 'userType:admin']], function(){
//     Route::get('/users', [AdminUserController::class, 'getAllUsers']);
// });

// protected routes:
Route::middleware('auth:sanctum')->group(function(){
    // admin user routes -- route to get all user
    Route::get('/users',[AdminUserController::class, 'getAllUsers'])->middleware(['auth', 'App\Http\Middleware\UserType:admin']);
    // route to create blogs -- normal user
    Route::post('/blogs',[BlogController::class, 'createBlog'])->middleware(['auth', 'App\Http\Middleware\UserType:normal']);
    // admin change the status of blog
    Route::put('/blogs/{id}',[BlogController::class, 'updateBlogStatus'])->middleware(['auth', 'App\Http\Middleware\UserType:admin']);
    // route to add comments from normal users
    Route::post('/blogs/{blog_id}/normal_comments',[CommentController::class, 'normalAddComment'])->middleware(['auth', 'App\Http\Middleware\UserType:normal']);
});