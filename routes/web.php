<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SupplierController;
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
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::group(['prefix' => 'categories'], function() {
        Route::get('/index', [CategoryController::class, 'index'])
            ->name('categories.index');
        Route::get('/create', [CategoryController::class, 'create'])
            ->name('categories.create');
        Route::post('/store', [CategoryController::class, 'store'])
            ->name('categories.store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])
            ->name('categories.edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])
            ->name('categories.update');
        Route::post('/destroy/{id}', [CategoryController::class, 'destroy'])
            ->name('categories.destroy');
    });

    Route::group(['prefix' => 'customers'], function() {
        Route::get('/index', [CustomerController::class, 'index'])
            ->name('customers.index');
        Route::get('/create', [CustomerController::class, 'create'])
            ->name('customers.create');
        Route::post('/store', [CustomerController::class, 'store'])
            ->name('customers.store');
        Route::get('/edit/{id}', [CustomerController::class, 'edit'])
            ->name('customers.edit');
        Route::post('/update/{id}', [CustomerController::class, 'update'])
            ->name('customers.update');
        Route::post('/destroy/{id}', [CustomerController::class, 'destroy'])
            ->name('customers.destroy');
    });

    Route::group(['prefix' => 'orders'], function() {
        Route::get('/index', [OrderController::class, 'index'])
            ->name('orders.index');
        Route::get('/create', [OrderController::class, 'create'])
            ->name('orders.create');
        Route::post('/store', [OrderController::class, 'store'])
            ->name('orders.store');
        Route::get('/show/{id}', [OrderController::class, 'show'])
            ->name('orders.show');
        Route::post('/destroy/{id}', [OrderController::class, 'destroy'])
            ->name('orders.destroy');
    });

    Route::group(['prefix' => 'receipts'], function() {
        Route::get('/show/{code}', [OrderController::class, 'receipt'])
            ->name('receipts.show');
    });

    Route::group(['prefix' => 'products'], function() {
        Route::get('/index', [ProductController::class, 'index'])
            ->name('products.index');
        Route::get('/create', [ProductController::class, 'create'])
            ->name('products.create');
        Route::post('/store', [ProductController::class, 'store'])
            ->name('products.store');
        Route::get('/show/{id}', [ProductController::class, 'show'])
            ->name('products.show');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])
            ->name('products.edit');
        Route::post('/update/{id}', [ProductController::class, 'update'])
            ->name('products.update');
        Route::post('/destroy/{id}', [ProductController::class, 'destroy'])
            ->name('products.destroy');
    });

    Route::group(['prefix' => 'profiles'], function () {
        Route::get('/index', [ProfileController::class, 'index'])
            ->name('profiles.index');
        Route::post('/update', [ProfileController::class, 'update'])
            ->name('profiles.update');
    });

    Route::group(['prefix' => 'purchases'], function() {
        Route::get('/index', [PurchaseController::class, 'index'])
            ->name('purchases.index');
        Route::get('/create', [PurchaseController::class, 'create'])
            ->name('purchases.create');
        Route::post('/store', [PurchaseController::class, 'store'])
            ->name('purchases.store');
        Route::get('/show/{id}', [PurchaseController::class, 'show'])
            ->name('purchases.show');
        Route::get('/edit/{id}', [PurchaseController::class, 'edit'])
            ->name('purchases.edit');
        Route::post('/update/{id}', [PurchaseController::class, 'update'])
            ->name('purchases.update');
        Route::post('/destroy/{id}', [PurchaseController::class, 'destroy'])
            ->name('purchases.destroy');
    });

    Route::group(['prefix' => 'settings'], function() {
        Route::get('/index', [SettingController::class, 'index'])
            ->name('settings.index');
        Route::get('/edit', [SettingController::class, 'edit'])
            ->name('settings.edit');
        Route::post('/update', [SettingController::class, 'update'])
            ->name('settings.update');
        Route::post('restore', [SettingController::class, 'restore'])
            ->name('settings.restore');
    });

    Route::group(['prefix' => 'suppliers'], function() {
        Route::get('/index', [SupplierController::class, 'index'])
            ->name('suppliers.index');
        Route::get('/create', [SupplierController::class, 'create'])
            ->name('suppliers.create');
        Route::post('/store', [SupplierController::class, 'store'])
            ->name('suppliers.store');
        Route::get('/edit/{id}', [SupplierController::class, 'edit'])
            ->name('suppliers.edit');
        Route::post('/update/{id}', [SupplierController::class, 'update'])
            ->name('suppliers.update');
        Route::post('/destroy/{id}', [SupplierController::class, 'destroy'])
            ->name('suppliers.destroy');
    });
});

require __DIR__ . '/auth.php';
