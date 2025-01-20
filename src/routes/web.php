<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\StripeController;

Route::group([], function () {

    // 新規登録画面
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    // 新規登録処理
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    // ログイン画面
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    // ログイン処理
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    // ログアウト処理
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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
    Route::get('/products/sold', [ProductController::class, 'soldProducts'])->name('products.sold');

    Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('editProfile');
    Route::post('/update-profile', [ProfileController::class, 'update'])->name('updateProfile');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/mypage/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    // プロフィール編集ページのルート
    Route::get('/mypage/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    // プロフィール更新のルート
    Route::post('/mypage', [ProfileController::class, 'update'])->name('updateProfile');

    // マイページのルート
    Route::get('/mypage', [ProfileController::class, 'show'])->name('mypage.show');

    Route::get('/purchase/create/{product}', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/address/update/{product}', [AddressController::class, 'update'])->name('address.update');
    Route::get('/address/change/{product}', [AddressController::class, 'edit'])->name('address.change');

    Route::post('/stripe/checkout', [StripeController::class, 'checkout'])->name('stripe.checkout');
    Route::get('/success', function () {
        return view('success'); // 成功時のビュー
    })->name('success');

    Route::get('/cancel', function () {
        return view('cancel'); // キャンセル時のビュー
    })->name('cancel');

    
});