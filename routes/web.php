<?php

use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('posts', PostsController::class)->except(['index', 'show'])->middleware('auth');
Route::get('/', [PostsController::class, 'index'])->name('posts.index');
Route::get('/posts', [PostsController::class, 'index']);
Route::get('/posts/{post}', [PostsController::class, 'show'])->name('posts.show');
Route::resource('posts.comments', PostCommentsController::class)->only(['store', 'destroy', 'update'])->middleware('auth');
Auth::routes();

