<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/master/users', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
