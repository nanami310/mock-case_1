<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

Route::middleware('auth')->group(function () {
    // ルートをProductControllerのindexメソッドに変更
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    
    // products.indexルートを定義
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    
    // products.createルートを定義
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/sell', [ProductController::class, 'create'])->name('products.create'); // 出品画面
    Route::post('/products', [ProductController::class, 'store'])->name('products.store'); // 商品登録

    Route::get('/mypage', [UserController::class, 'showMypage'])->name('mypage');
    Route::get('/mypage/edit', [UserController::class, 'editProfile'])->name('editProfile');

    Route::get('/item/{id}', [ProductController::class, 'show'])->name('item.show');
    Route::post('/products/{item_id}/comments', [ProductController::class, 'storeComment'])->name('comments.store');

    Route::post('/products/{id}/like', [ProductController::class, 'like'])->name('products.like');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

    Route::post('/products/{id}/unlike', [ProductController::class, 'unlike'])->name('products.unlike');
});