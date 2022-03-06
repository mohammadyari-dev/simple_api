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
 * @author Mohammad.Y <mhd.yari021@gmail.com>
 */
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
Route::resource('users.posts', 'User\UserPostController', ['except' => ['create', 'show', 'edit']]);
Route::resource('users.categories', 'User\UserCategoryController', ['only' => ['index']]);

/**
 * Posts routes
 * @author Mohammad.Y <mhd.yari021@gmail.com>
 */
Route::resource('posts', 'Post\PostController', ['only' => ['index', 'show']]);
Route::resource('posts.categories', 'Post\PostCategoryController', ['only' => ['index', 'update', 'destroy']]);

/**
 * Categories routes
 * @author Mohammad.Y <mhd.yari021@gmail.com>
 */
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);
Route::resource('categories.posts', 'Category\CategoryPostController', ['only' => ['index']]);
Route::resource('categories.users', 'Category\CategoryUserController', ['only' => ['index']]);

/**
 * Auth routes
 * @author Mohammad.Y <mhd.yari021@gmail.com>
 */
Route::post('/login', 'Auth\LoginController@authenticate')->name('login');
Route::post('/register', 'Auth\LoginController@register')->name('register');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
