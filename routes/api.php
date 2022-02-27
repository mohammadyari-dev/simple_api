<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Users routes
 */
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
Route::resource('users.posts', 'User\UserPostController', ['except' => ['create', 'show', 'edit']]);
Route::resource('users.categories', 'User\CategoryController', ['only' => ['index']]);

/**
 * Posts routes
 */
Route::resource('posts', 'Post\PostController', ['only' => ['index', 'show']]);

/**
 * Categories routes
 */
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);
