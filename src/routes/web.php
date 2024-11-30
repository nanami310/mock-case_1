<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

Route::middleware('auth')->group(function () {
    // ルートをProductControllerのindexメソッドに変更
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    
    // products.indexルートを定義
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    
    // products.createルートを定義
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/sell', [ProductController::class, 'create'])->name('products.create'); // 出品画面
    Route::post('/products', [ProductController::class, 'store'])->name('products.store'); // 商品登録
});