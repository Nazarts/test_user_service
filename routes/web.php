<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return redirect('/home');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\UserController::class, 'profile_update'])->name('profile_update');
    Route::middleware('role:Admin')->group(function () {
        Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('create');
        Route::post('/users/store', [App\Http\Controllers\UserController::class, 'store'])->name('store');
        Route::delete('/users/{id}', [App\Http\Controllers\UserController::class, 'delete'])->name('delete');
        Route::put('/users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('update');
        Route::get('/users/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('edit');
    });
    Route::get('/users/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('show');
});
