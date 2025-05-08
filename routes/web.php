<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Api\StockMovementController;


Route::get('/', [OrderController::class, 'index'])->name('orders');


Route::get('/warehouses', [WarehouseController::class, 'index'])->name('warehouses');
Route::get('/products', [ProductController::class, 'index'])->name('products');

Route::get('/orders', [OrderController::class, 'index'])->name('orders');
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');

Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
Route::post('/orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');
Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
Route::post('/orders/{order}/resume', [OrderController::class, 'resume'])->name('orders.resume');
Route::get('/stock_movements/{order}', [StockMovementController::class, 'index'])->name('stock_movements');;
