<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/upload', [ProductController::class, 'upload'])->name('products.upload');
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
