<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogPostController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('posts', BlogPostController::class);
});

