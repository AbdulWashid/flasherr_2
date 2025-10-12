<?php

use Illuminate\Support\Facades\Route;
//admin Routes
use App\Http\Controllers\Admin\{AuthController, DashboardController, ProfileController, SaleRequestController as AdminSaleRequestController, SaleController as AdminSaleController};

//user Routes

use App\Http\Controllers\User\{HomeController, SaleController,BuyController,BuyRequestController};

//admin routes
Route::get('/login', [AuthController::class, 'index'])->name('loginform');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('sale-request', AdminSaleRequestController::class);
    Route::delete('/sale-request/{sale}/document', [AdminSaleRequestController::class, 'deleteDocument'])->name('sale-request.document.delete');
    Route::patch('sale-request/{sale}/update-status', [AdminSaleRequestController::class, 'updateStatus'])->name('sale-request.updateStatus');

    Route::resource('sale', AdminSaleController::class);
    Route::post('sale/update-status/{sale}', [AdminSaleController::class, 'updateStatus'])->name('sale.updateStatus');
    Route::post('sale/update-display-status/{sale}', [AdminSaleController::class, 'updateDisplayStatus'])->name('sale.updateDisplayStatus');
    Route::get('sale/create-from-request/{saleRequest}', [AdminSaleController::class, 'createFromRequest'])->name('sale.createFromRequest');

    Route::get('buy-requests', [BuyRequestController::class, 'buyRequests'])->name('buy-requests.index');
    Route::post('admin/buy-requests/update-status/{buyRequest}', [BuyRequestController::class, 'updateStatus'])->name('buy-requests.updateStatus');
    Route::delete('admin/buy-requests/{buyRequest}', [BuyRequestController::class, 'destroy'])->name('buy-requests.destroy');
});

// user routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sale', [SaleController::class, 'index'])->name('sale');
Route::post('/sale', [SaleController::class, 'store'])->name('sale.store');
Route::get('/buy', [BuyController::class, 'salesIndex'])->name('buy');
Route::get('/buy-detail/{sale}', [BuyController::class, 'showSaleDetails'])->name('buy.detail');
Route::post('/buy-request', [BuyRequestController::class, 'store'])->name('buy.request.store');
