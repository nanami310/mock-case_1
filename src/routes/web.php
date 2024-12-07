<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AddressController;

Route::middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'index']); // AuthControllerでリダイレクト
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/products/{id}/comments', [CommentController::class, 'store'])->name('comments.store');

    // マイページのルート設定
    Route::get('/mypage', [ProfileController::class, 'index'])->name('mypage.index');
    Route::get('/mypage?page=buy', [ProfileController::class, 'showPurchased'])->name('mypage.purchased');
    Route::get('/mypage?page=sell', [ProfileController::class, 'showSold'])->name('mypage.sold');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/products/{product}/like', [ProductController::class, 'like'])->name('products.like');
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'show'])->name('purchase.show');
    Route::get('/address/change', [AddressController::class, 'edit'])->name('address.change');
    Route::post('/address/update', [AddressController::class, 'update'])->name('address.update');
});