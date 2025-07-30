<?php

use App\Http\Controllers\BlogFrontController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogPostController;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('admin.login');
});

Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    // Route::resource('posts', BlogPostController::class);
    Route::resource('posts', BlogPostController::class)->except(['show']);
    // SLUG URL Route
    Route::get('posts/check-url', [BlogPostController::class, 'checkUrl'])->name('posts.check-url');
});

// Route::get('/admin/posts', [BlogPostController::class, 'index'])->name('admin.posts.index');


Route::get('/blog',[BlogFrontController::class,'index'])->name('blog.index');
Route::get('/blog/{slug}',[BlogFrontController::class,'show'])->name('blog.show');