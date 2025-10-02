<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
                            AuthController,
                            DashboardController,
                            ProfileController
                          };

//admin routes
Route::get('/login', [AuthController::class, 'index'])->name('loginform');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});


Route::get('/', function () {
    dd('hello');
});
