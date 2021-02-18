<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\UserPostController;


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
Route::get('/', function () {
    return view('home');
})->name('home');
Route::post('/logout',[LogoutController::class, 'store'])->name('logout');
Route::get('/login',[LoginController::class, 'index'])->name('login');                   //set ->middleware('guest') or other way is set middleware('auth') in LoginController
Route::post('/login',[LoginController::class, 'store']);                                 //->middleware('guest') or other way is set middleware('auth') in LoginController
Route::get('/register',[RegisterController::class, 'index'])->name('register');          //->middleware('guest') or other way is set middleware('auth') in RegisterController
Route::post('/register',[RegisterController::class, 'store']);                           //->middleware('guest') or other way is set middleware('auth') in RegisterController
Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');       //->middleware('auth')  or other way is set middleware('auth') in DashboardController

Route::get('/posts',[PostController::class, 'index'])->name('posts');
Route::get('/posts/{post}',[PostController::class, 'show'])->name('posts.show');
Route::post('/posts',[PostController::class, 'store']);
Route::delete('/posts/{post}',[PostController::class, 'destroy'])->name('posts.destroy');        //{post} means route model binding //{post} Shows corresponding ID in URL

Route::post('/posts/{post}/likes',[PostLikeController::class, 'store'])->name('posts.likes');
Route::delete('/posts/{post}/likes',[PostLikeController::class, 'destroy'])->name('posts.likes');

Route::get('/users/{user:name}/posts',[UserPostController::class, 'index'])->name('users.posts');       //{user:name} means route model binding //{user:name} Shows corresponding user's name instead of ID in URL