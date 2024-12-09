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
    // 商品一覧画面
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    
    // 商品一覧画面_マイリスト
    Route::get('mylist', [ProductController::class, 'myList'])->name('products.mylist');
    
    // 商品詳細画面
    Route::get('/item/{item_id}', [ProductController::class, 'show'])->name('products.show');

    // 商品購入画面
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'show'])->name('purchase.show');

    // 送付先住所変更画面
    Route::get('/purchase/address/{item_id}', [AddressController::class, 'edit'])->name('address.change')->where('userList', '[0-9]+');

    // 商品出品画面
    Route::get('/sell', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // プロフィール画面
    Route::get('/mypage', [ProfileController::class, 'index'])->name('mypage.index');
    
    // プロフィール編集画面
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['put', 'post'], '/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');


    // プロフィール画面_購入した商品一覧
    Route::get('/mypage?page=buy', [ProfileController::class, 'showPurchased'])->name('mypage.purchased');
    
    // プロフィール画面_出品した商品一覧
    Route::get('/mypage?page=sell', [ProfileController::class, 'showSold'])->name('mypage.sold');

    // いいね機能
    Route::post('/products/{product}/like', [ProductController::class, 'like'])->name('products.like');

    // コメント機能
    Route::post('/products/{id}/comments', [CommentController::class, 'store'])->name('comments.store');
});

// 会員登録画面
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// ログイン画面
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');